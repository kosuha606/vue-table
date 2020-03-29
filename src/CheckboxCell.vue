<template>
    <td>
        <input @change="onChange" type="checkbox">
    </td>
</template>

<script>
    export default {
        name: "CheckboxCell",
        methods: {
            onChange(e) {
                this.$emit('change', e.target.value);
            }
        }
    }
</script>

<style scoped>

</style>