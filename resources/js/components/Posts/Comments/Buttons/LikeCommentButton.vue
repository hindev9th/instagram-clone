<template>
    <div class="like-post prevent-select cursor-pointer" title="Like">
        <i class="fa-heart" :class="iconButton" @click="likeComment" style="font-size: 18px"></i>
    </div>
</template>

<script>
import $api from "../../../../api/apiClient";
import {RESOURCE_LIKES} from "../../../../api/likeApi";

export default {
    name: "LikeCommentButton",
    props: ['comment'],
    mounted() {
        this.status = this.comment.isLiked;
    },
    data: function () {
        return {
            status: false,
            notLike: 'far',
            isLike: 'fas text-danger',
        }
    },
    methods: {
        likeComment(event) {
            this.toggleClass(event);
            this.status = !this.status;
            $api.post(`${RESOURCE_LIKES}/comment/${this.comment.id}`)
                .then(response => {
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

<style scoped>

</style>
