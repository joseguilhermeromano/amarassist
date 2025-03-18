<template>
    <div class="structure">
        <!-- Menu Superior -->
        <nav class="custom-nav">
            <div class="nav-wrapper">
                <div class="container">
                    <div class="row">
                        <div class="col s12">
                            <!-- Logo à esquerda -->
                            <a href="#" class="brand-logo left">
                                <img
                                    src="/img/logo-amar-assist.png"
                                    alt="Logo"
                                />
                            </a>
                            <!-- Itens do menu à direita -->
                            <ul class="right">
                                <li>
                                    <a href="#!"
                                        ><i class="fa fa-list small-icon"></i
                                        >Produtos</a
                                    >
                                </li>
                                <li>
                                    <a href="#" @click="logout"
                                        ><i
                                            class="fa fa-sign-out small-icon"
                                        ></i
                                        >Logout</a
                                    >
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Conteúdo Principal -->
        <main class="container">
            <div class="row">
                <div class="col s12">
                    <div class="page-title">
                        <h4>Produtos</h4>
                        <a
                            class="btn waves-effect waves-light btn-orange new-product"
                            @click="createProduct"
                        >
                            <i class="fa fa-plus small-icon"></i>Novo Produto
                        </a>
                    </div>
                    <div class="input-field">
                        <input
                            id="search"
                            type="text"
                            v-model="searchQuery"
                            @input="filterProducts"
                        />
                        <label for="search">Buscar Produto</label>
                    </div>
                    <table class="striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Descrição</th>
                                <th>Preço</th>
                                <th class="text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="product in filteredProducts"
                                :key="product.id"
                            >
                                <td>{{ product.id }}</td>
                                <td>{{ product.name }}</td>
                                <td>{{ product.description }}</td>
                                <td>{{ product.price }}</td>
                                <td class="table-actions">
                                    <a
                                        class="btn-flat btn-action"
                                        @click="viewProduct(product.id)"
                                    >
                                        <i class="fa fa-eye small-icon"></i>
                                        Detalhes
                                    </a>
                                    <a
                                        class="btn-flat btn-action"
                                        @click="editProduct(product.id)"
                                    >
                                        <i class="fa fa-edit small-icon"></i>
                                        Editar
                                    </a>
                                    <a
                                        class="btn-flat btn-action"
                                        @click="deleteProduct(product.id)"
                                    >
                                        <i class="fa fa-trash small-icon"></i>
                                        Excluir
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>

        <!-- Rodapé -->
        <footer class="page-footer custom-footer">
            <div class="container">
                <div class="row">
                    <div class="col s12">
                        <p class="grey-text center-align">
                            © {{ currentYear }} Desenvolvido com
                            <i class="fa fa-heart small-icon heart-icon"></i>por
                            José Romano
                        </p>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</template>

<script>
export default {
    name: "Dashboard",
    data() {
        return {
            searchQuery: "",
            products: [
                {
                    id: 1,
                    name: "Produto 1",
                    description: "Descrição do Produto 1",
                    price: "R$ 100,00",
                },
                {
                    id: 2,
                    name: "Produto 2",
                    description: "Descrição do Produto 2",
                    price: "R$ 200,00",
                },
                {
                    id: 3,
                    name: "Produto 3",
                    description: "Descrição do Produto 3",
                    price: "R$ 300,00",
                },
            ],
            filteredProducts: [],
        };
    },
    computed: {
        currentYear() {
            return new Date().getFullYear();
        },
    },
    methods: {
        logout() {
            localStorage.removeItem("token");
            delete axios.defaults.headers.common["Authorization"];
            this.$inertia.visit("/", { replace: true });
        },
        createProduct() {
            alert("Criar novo produto");
        },
        viewProduct(id) {
            alert(`Visualizar produto com ID: ${id}`);
        },
        editProduct(id) {
            alert(`Editar produto com ID: ${id}`);
        },
        deleteProduct(id) {
            if (confirm("Tem certeza que deseja excluir este produto?")) {
                this.products = this.products.filter(
                    (product) => product.id !== id
                );
                this.filterProducts();
            }
        },
        filterProducts() {
            if (this.searchQuery) {
                this.filteredProducts = this.products.filter((product) =>
                    product.name
                        .toLowerCase()
                        .includes(this.searchQuery.toLowerCase())
                );
            } else {
                this.filteredProducts = this.products;
            }
        },
    },
    mounted() {
        // Inicializa a lista de produtos filtrados com todos os produtos
        this.filteredProducts = this.products;
    },
};
</script>

<style lang="scss" scoped>
$blue-color: #621587;
$orange-color: #f36606;
/* Estilos específicos para o componente */
body {
    display: flex;
    min-height: 100vh;
    flex-direction: column;
}

main {
    flex: 1 0 auto;
}

.page-footer {
    padding-top: 0;
}

.brand-logo img {
    height: 75px;
    vertical-align: middle;
}

.custom-nav {
    background-color: #f5f5f5 !important;
    box-shadow: 0 4px 6px -2px rgba(0, 0, 0, 0.2);
}

.custom-nav a {
    color: $blue-color !important;
    font-weight: bold;
}

.custom-nav a:hover {
    color: #5d6d7e !important;
}

.custom-nav .brand-logo {
    color: $blue-color !important;
}

.custom-footer {
    background-color: #f5f5f5 !important;
    color: #909497 !important;
    box-shadow: 0 -4px 6px -2px rgba(0, 0, 0, 0.2);
}

.structure {
    display: flex;
    flex-direction: column;
}

.heart-icon {
    color: red;
}

.small-icon {
    font-size: 14px;
    margin-right: 5px;
}

.btn-orange {
    background-color: $orange-color !important;
    color: white !important;
}

.page-title {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
}

table.striped {
    border-collapse: collapse;
    width: 100%;
    margin-top: 20px;
}

table.striped th,
table.striped td {
    border: 1px solid #ddd;
    padding: 12px;
    text-align: left;
}

table.striped th {
    background-color: #f5f5f5;
    font-weight: bold;
}

table.striped tr:nth-child(even) {
    background-color: #f9f9f9;
}

table.striped tr:hover {
    background-color: #f1f1f1;
}

.btn-action {
    margin: 0 5px;
    color: $blue-color !important;
}

.btn-action:hover {
    color: $orange-color !important;
}

.new-product {
    margin-top: 25px;
}
.table-actions {
    display: flex;
    flex-direction: column;
    justify-content: start;
    align-items: start;
}

.text-center {
    text-align: center;
}
</style>
