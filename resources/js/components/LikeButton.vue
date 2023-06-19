<template>
    <div class="">
        <i class="fa-heart" :class="iconButton" @click="likePost" style="font-size: 25px"></i>
<!--        <i class="far" :class="iconButton" @click="likePost" aria-hidden="true"></i>-->
    </div>
</template>

<script>
export default {
    props: ['postId', 'like'],
    mounted() {
        console.log('Component mounted.')
    },
    methods: {
        likePost() {
            axios.post('/p/' + this.postId + '/like').then(response => {
                    this.status = !this.status;
                    console.log(response.data);
                }
            )
        }
    },
    data: function () {
        return {
            status: this.like,
            notLike: 'far',
            isLike: 'fas text-danger',
        }
    },
    computed: {
        iconButton() {
            return this.status ? this.isLike : this.notLike;
        }
    }
}
</script>
