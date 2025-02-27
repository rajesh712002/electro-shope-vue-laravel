<template>
    <main>
        <section class="section-5 pt-3 pb-3 mb-3 bg-white">
            <div class="container">
                <div class="light-font">
                    <ol class="breadcrumb primary-color mb-0">
                        <li class="breadcrumb-item"><router-link to="/">Home</router-link></li>
                        <li class="breadcrumb-item"><router-link to="/shop">Shop</router-link></li>
                        <li class="breadcrumb-item">{{ product.prod_name }}</li>
                    </ol>
                </div>
            </div>
        </section>

        <section class="section-7 pt-3 mb-3">
            <div class="container">
                <div class="row">
                    <div class="col-md-5">
                        <img :src="brandImage" class="brand-img" />
                        <div id="product-carousel" class="carousel slide" data-bs-ride="carousel">
                            <div v-if="images.length > 0" class="carousel-inner bg-light">
                                <div v-for="(image, key) in images" :key="key"
                                    :class="['carousel-item', { active: key === 0 }]">
                                    <img :src="getImagePath(image.images)" :alt="`Image ${key + 1}`" />
                                </div>
                            </div>
                            <div v-else class="carousel-inner bg-light">
                                <img :src="getImagePath(product.image)" alt="Product Image" />
                            </div>
                        </div>
                    </div>

                    <div class="col-md-7">
                        <div class="bg-light right">
                            <h1>{{ product.prod_name }}</h1>
                            <div class="d-flex mb-3">
                                <div class="text-primary" v-if="ratingcount > 0" :title="ratingPercentage + '%'">
                                    <div class="back-stars">
                                        <i class="fa fa-star" v-for="n in 5" :key="n"></i>
                                        <div class="front-stars" :style="{ width: ratingPercentage + '%' }">
                                            <i class="fa fa-star" v-for="n in 5" :key="n"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <small class="pt-1">({{ ratingcount }} Reviews)</small>
                            <h2 class="price text-secondary"><del>{{ product.compare_price }}</del></h2>
                            <h2 class="price">{{ product.price }}</h2>
                            <p v-html="product.description"></p>
                            <button @click="addToCart" class="btn btn-dark"><i class="fas fa-shopping-cart"></i>&nbsp;
                                ADD TO CART</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section-8 pt-3 pb-3">
            <div class="container">
                <div class="col-md-8" v-if="isLoggedIn">
                    <form @submit.prevent="submitReview" id="ProductRatingForm">
                        <div class="row">
                            <h3 class="h4 pb-3">Write a Review</h3>

                            <div class="form-group col-md-6 mb-3">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" v-model="review.name" placeholder="Name">
                                <p class="text-danger">{{ errors.name }}</p>
                            </div>

                            <div class="form-group col-md-6 mb-3">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" v-model="review.email" placeholder="Email">
                                <p class="text-danger">{{ errors.email }}</p>
                            </div>

                            <div class="form-group mb-3">
                                <label for="rating">Rating</label>
                                <div class="rating d-flex">
                                    <span v-for="n in 5" :key="n" class="star" @click="review.rating = n">
                                        <i
                                            :class="['fas fa-2x', review.rating >= n ? 'fa-star text-warning' : 'fa-star text-secondary']"></i>
                                    </span>
                                </div>
                                <p class="text-danger">{{ errors.rating }}</p>
                            </div>

                            <div class="form-group mb-3">
                                <label for="comment">How was your overall experience?</label>
                                <textarea v-model="review.comment" class="form-control" cols="30" rows="5"
                                    placeholder="Write your review here..."></textarea>
                                <p class="text-danger">{{ errors.comment }}</p>
                            </div>

                            <div>
                                <button type="submit" class="btn btn-dark">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
        
    </main>
</template>

<script>
export default {
    data() {
        return {
            product: {},
            images: [],
            ratingcount: 0,
            ratingsum: 0,
            productrat: [],
            isLoggedIn: true, // Modify based on actual authentication check
            review: {
                name: '',
                email: '',
                rating: null,
                comment: ''
            },
            errors: {}
        };
    },
    computed: {
        brandImage() {
            return `/admin_assets/images/${this.product.brand?.image}`;
        },
        ratingPercentage() {
            return this.ratingcount > 0 ? ((this.ratingsum / this.ratingcount) * 100) / 5 : 0;
        },
    },
    methods: {
        getImagePath(image) {
            return `/admin_assets/images/${image}`;
        },
        addToCart() {
            console.log("Adding to cart", this.product);
        },
        async fetchProducts() {
            const productSlug = this.$route.params.slug;
            try {
                const response = await axios.get(`/api/view-product/${productSlug}`);
                this.product = response.data.product;
                this.images = response.data.images;
                this.ratingcount = response.data.ratingcount;
                this.ratingsum = response.data.ratingsum;
                this.productrat = response.data.productrat;
                console.log(response)
            } catch (error) {
                console.error('Error fetching products:', error);
            }
        },
        async submitReview() {
            try {
                await axios.post(`/api/review/${this.product.id}`, this.review);
                alert('Review submitted successfully!');
                this.review = { name: '', email: '', rating: null, comment: '' };
                this.fetchProducts(); // Refresh product details
            } catch (error) {
                if (error.response && error.response.data.errors) {
                    this.errors = error.response.data.errors;
                }
            }
        }
    },
    mounted() {
        this.fetchProducts();
    },
};
</script>

<style scoped>
.brand-img {
    width: 100px;
    height: 70px;
    object-fit: contain;
}

.back-stars {
    position: relative;
    color: #ccc;
}

.front-stars {
    position: absolute;
    color: gold;
    overflow: hidden;
    white-space: nowrap;
}
</style>



<!-- <script>
export default {
    data() {
        return {
            product: {},
            images: [],
            ratingcount: 0,
            ratingsum: 0,
            productrat:[]
        };
    },
    computed: {
        brandImage() {
            return `/admin_assets/images/${this.product.brand?.image}`;
        },
        ratingPercentage() {
            return this.ratingcount > 0 ? ((this.ratingsum / this.ratingcount) * 100) / 5 : 0;
        },
    },
    methods: {
        getImagePath(image) {
            return `/admin_assets/images/${image}`;
        },
        addToCart() {
            console.log("Adding to cart", this.product);
        },
        async fetchProducts() {
            const productSlug = this.$route.params.slug;
            console.log(productSlug)
            try {
                const response = await axios.get(`/api/view-product/${productSlug}`);
                this.product = response.data.product;
                this.images = response.data.images;
                this.ratingcount = response.data.ratingcount;
                this.ratingsum = response.data.ratingsum;
                this.productrat = response.data.productrat;
                

                console.log(response)
            } catch (error) {
                console.error('Error fetching products:', error);
            }
        },
    },
    mounted() {
        // Fetch product details from API or props
        this.fetchProducts();
    },
};
</script> -->
