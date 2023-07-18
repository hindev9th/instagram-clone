<template>
    <div class="like-post">
        <i class="fa-heart" :class="iconButton" @click="likePost" style="font-size: 25px"></i>
    </div>
</template>

<script>
export default {
    props: ['post', 'user'],
    mounted() {
        this.status = this.post.isLiked;
    },
    data: function () {
        return {
            status: false,
            notLike: 'far',
            isLike: 'fas text-danger',
        }
    },
    methods: {
        likePost(event) {
            this.toggleClass(event);
            this.status = !this.status;
            axios.post(window.Laravel.baseUrl + '/p/' + this.post.id + '/like').then(response => {
                    response.data.attached.length ? this.$emit('add-like') : this.$emit('minus-like');
                }
            );
        },
        toggleClass (event) {
            const target = event.target;
            target.classList.add("flashing");

            const onAnimationEnd = () => {
                target.removeEventListener('animationend', onAnimationEnd);
                target.classList.remove("flashing");
            };

            target.addEventListener('animationend', onAnimationEnd);
        }
    },

    computed: {
        iconButton() {
            return this.status ? this.isLike : this.notLike;
        }
    }
}
</script>
<style>
    .like-post{
        cursor: pointer;
    }
    .flashing {
        transform: scale(1);
        animation: scale .3s;
    }

    @keyframes scale {
        0% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.5);
        }
        100% {
            transform: scale(1);
        }
    }
</style>
