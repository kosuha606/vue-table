<template>
    <td>
        <input :checked="checked" @change="onChange" type="checkbox">
    </td>
</template>

<script>
    export default {
        name: "CheckboxCell",
        props: ['massOperations', 'component'],
        data() {
            return {
                checked: false,
            }
        },
        mounted() {
            this.checked = this.isChecked();
        },
        methods: {
            onChange(e) {
                if (e.target.checked) {
                    this.$emit('mass-select', this.$attrs.item.id);
                } else {
                    this.$emit('mass-unselect', this.$attrs.item.id);
                }
            },
            isChecked() {
                if (this.massOperations[this.component.massOperation]) {
                    if (this.massOperations[this.component.massOperation][this.$attrs.item.id]) {
                        return true;
                    }
                }

                return false;
            }
        }
    }
</script>

<style scoped>

</style>