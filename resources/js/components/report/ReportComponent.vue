<template>
    <router-link :to="{ name: name }">
        <div class="card">
            <font-awesome-icon
                icon="fa-solid fa-file"
                style="color: rgb(0, 144, 144)"
                size="5x"
            />
            <h3>{{ title }}</h3>
        </div>
    </router-link>
</template>

<script>
export default {
    props: ["title", "name"],
    setup(props) {
        return {
            title: props.title,
        };
    },
};
</script>

<style scoped>
.card {
    width: 100%;
    height: auto;
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    overflow: hidden;
    margin: 10px;
    display: flex;
    flex-direction: row;
    justify-content: center;
    align-items: center;
    text-decoration: none;
    color: #000;
    padding: 3rem 2rem;
    gap: 1rem;
}

.card h3 {
    margin: 0;
    padding: 0;
    font-size: 1.5rem;
    font-weight: 600;
}
</style>
