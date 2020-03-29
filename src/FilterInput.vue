<template>
    <div>
        <input @change="onChange" type="text">
    </div>
</template>

<script>
    export default {
        name: "FilterInput",
        methods: {
            onChange(e) {
                this.$emit('input', e.target.value);
            }
        }
    }
</script>

<style scoped>

</style>