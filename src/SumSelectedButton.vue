<template>
    <div>
        <button @click="calc">
            {{ $attrs.props.label }}
        </button>
    </div>
</template>

<script>
    export default {
        name: "SumSelectedButton",
        props: ['massOperations'],
        methods: {
            calc() {
                if (!this.massOperations.selected) {
                    alert('Ничего не выбрано');
                    return;
                }
                var ids = Object.keys(this.massOperations.selected);
                alert('Выбраны: '+ids.join(','));
            }
        }
    }
</script>

<style scoped>

</style>