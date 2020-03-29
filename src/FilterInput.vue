<template>
    <div>
        <label for="">
            {{ label }}
        </label>
        <input @change="onChange" type="text" :value="value">
    </div>
</template>

<script>
    export default {
        name: "FilterInput",
        props: ['value', 'label'],
        methods: {
            onChange(e) {
                this.$emit('input', e.target.value);
            }
        }
    }
</script>

<style scoped>

</style>