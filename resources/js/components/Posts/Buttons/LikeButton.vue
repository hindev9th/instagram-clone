<template>
    <div class="like-post">
        <i class="fa-heart" :class="iconButton" @click="likePost" style="font-size: 25px"></i>
    </div>
</template>

<script>
export default {
    props: ['postId', 'like'],
    mounted() {

    },
    methods: {
        likePost(event) {
            axios.post('/p/' + this.postId + '/like').then(response => {
                    this.status = !this.status;
                    this.toggleClass(event);
                }
            )
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
<style>
    .like-post{
        cursor: pointer;
    }
    .flashing {
        transform: scale(1);
        animation: scale .5s;
    }

    @keyframes scale {
        0% {
            transform: scale(1);
        }
        50% {
            /*transform: scale(1.5);*/
        }
        70%{
            transform: scale(2);
        }
        100% {
            transform: scale(1);
        }
    }
</style>
