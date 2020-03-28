<template>
    <div>
        <button>
            {{ label }}
        </button>
    </div>
</template>

<script>
    export default {
        name: "Button",
        props: {
            label: String,
        }
    }
</script>

<style scoped>

</style>