<script>
import { defineComponent } from "vue";

export default defineComponent({
    name: "HelloWorld",
    data() {
        return {
            message: "Hello World!",
        };
    },
});
</script>

<template>
    <h1>{{ message }}</h1>
</template>

<style scoped>
h1 {
    color: #42b983;
}
</style>
