<template>
    <span>
        <span v-for="token in tokens">
                <router-link
                    v-if="token.startsWith('@')"
                    :to="{name : 'profile', params : {username : token.slice(1) }}">
                    @{{token.slice(1)}}
                </router-link>
            <span v-else>
                &nbsp;{{token}}
            </span>
        </span>
    </span>
</template>

<script>
export default {
    name : 'MentionLink',
    props : ['text'],
    data() {
        return {
            content: "Hello, this is a mention tag example. Mention @john.doe and @jane.smith.",
            mentionRegex: /@([\w.]+)/g,
        };
    },
    methods: {
        convertMentionToRouterLink() {
            // Replace mention tags with <router-link> elements
            return this.text.replace(this.mentionRegex, (match, username) => {
                return `<router-link :to="{ name: 'user-profile', params: { username: '${username}' } }">${match}</router-link>`;
            });
        },
    },
    computed: {
        renderedContent() {
            // Call the conversion method and return the converted content as raw HTML
            return this.convertMentionToRouterLink();
        },
        tokens(){
            return this.text.split(' ');
        },
        textReplaced(){
            return this.text.split(' ').map(w => {
                return w.startsWith('@') ? `<a href="${w.slice(1)}>${w}</a>"` : w;
            })
        },
    },
};
</script>
