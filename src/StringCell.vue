<template>
    <td>
        <a v-if="$attrs.props && $attrs.props.link" :href="$attrs.props.link(item)">
            {{ item[field] }}
        </a>
        <span v-else>
            {{ item[field] }}
        </span>
    </td>
</template>

<script>
    export default {
        name: "StringCell",
        props: {
            value: [String, Number],
            item: Object,
            field: String,
        }
    }
</script>

<style scoped>

</style>