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
                            @click="openCreateModal"
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
                                <th>Preço de Venda</th>
                                <th>Custo</th>
                                <th class="text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="product in filteredProducts"
                                :key="product.id"
                            >
                                <td>{{ product.id }}</td>
                                <td>{{ product.title }}</td>
                                <td v-html="product.description"></td>
                                <td>
                                    {{ formatCurrency(product.sale_price) }}
                                </td>
                                <td>{{ formatCurrency(product.cost) }}</td>
                                <td class="table-actions">
                                    <a
                                        class="btn-flat btn-action"
                                        @click="viewProduct(product.id)"
                                    >
                                        <i class="fa fa-eye small-icon"></i
                                        >Detalhes
                                    </a>
                                    <a
                                        class="btn-flat btn-action"
                                        @click="openEditModal(product)"
                                    >
                                        <i class="fa fa-edit small-icon"></i
                                        >Editar
                                    </a>
                                    <a
                                        class="btn-flat btn-action"
                                        @click="deleteProduct(product.id)"
                                    >
                                        <i class="fa fa-trash small-icon"></i
                                        >Excluir
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>

        <!-- Modal para Criar/Editar Produto -->
        <div v-show="isModalOpen" class="modal">
            <div class="modal-content">
                <h4>{{ isEditing ? "Editar Produto" : "Novo Produto" }}</h4>
                <form
                    @submit.prevent="
                        isEditing ? updateProduct() : createProduct()
                    "
                >
                    <div class="input-field">
                        <input
                            id="title"
                            type="text"
                            v-model="form.title"
                            required
                        />
                        <label for="title">Título</label>
                    </div>
                    <div class="input-field">
                        <input
                            id="sale_price"
                            type="number"
                            v-model="form.sale_price"
                            required
                        />
                        <label for="sale_price">Preço de Venda</label>
                    </div>
                    <div class="input-field">
                        <input
                            id="cost"
                            type="number"
                            v-model="form.cost"
                            required
                        />
                        <label for="cost">Custo</label>
                    </div>
                    <div class="input-field">
                        <textarea
                            id="description"
                            v-model="form.description"
                            class="materialize-textarea"
                            required
                        ></textarea>
                        <label for="description">Descrição</label>
                    </div>
                    <div class="input-field">
                        <input
                            id="images"
                            type="text"
                            v-model="form.images"
                            required
                        />
                        <label for="images"
                            >Imagens (URLs separadas por vírgula)</label
                        >
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-flat" @click="closeModal">
                    Cancelar
                </button>
                <button
                    type="submit"
                    class="btn waves-effect waves-light btn-orange"
                >
                    {{ isEditing ? "Salvar" : "Criar" }}
                </button>
            </div>
        </div>

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
import axios from "axios";
import M from "materialize-css";

export default {
    name: "Dashboard",
    data() {
        return {
            searchQuery: "",
            products: [],
            filteredProducts: [],
            isModalOpen: false,
            isEditing: false,
            form: {
                id: null,
                title: "",
                sale_price: "",
                cost: "",
                description: "",
                images: "",
            },
            modalInstance: null, // Armazena a instância do modal
        };
    },
    computed: {
        currentYear() {
            return new Date().getFullYear();
        },
    },
    methods: {
        async fetchProducts() {
            try {
                const response = await axios.get("/api/products");
                this.products = response.data;
                this.filteredProducts = this.products;
            } catch (error) {
                console.error("Erro ao buscar produtos:", error);
            }
        },
        openCreateModal() {
            this.isEditing = false;
            this.form = {
                id: null,
                title: "",
                sale_price: "",
                cost: "",
                description: "",
                images: "",
            };
            this.isModalOpen = true;
            this.$nextTick(() => {
                this.modalInstance = M.Modal.init(
                    document.querySelector(".modal"),
                    {}
                );
                this.modalInstance.open();
            });
        },
        openEditModal(product) {
            this.isEditing = true;
            this.form = {
                id: product.id,
                title: product.title,
                sale_price: product.sale_price,
                cost: product.cost,
                description: product.description,
                images: product.images.join(", "),
            };
            this.isModalOpen = true;
            this.$nextTick(() => {
                this.modalInstance = M.Modal.init(
                    document.querySelector(".modal"),
                    {}
                );
                this.modalInstance.open();
            });
        },
        closeModal() {
            this.isModalOpen = false;
            if (this.modalInstance) {
                this.modalInstance.close();
            }
        },
        async createProduct() {
            try {
                const response = await axios.post("/api/products", {
                    ...this.form,
                    images: this.form.images
                        .split(",")
                        .map((url) => url.trim()),
                });
                this.products.push(response.data);
                this.filterProducts();
                this.closeModal();
            } catch (error) {
                console.error("Erro ao criar produto:", error);
            }
        },
        async updateProduct() {
            try {
                const response = await axios.put(
                    `/api/products/${this.form.id}`,
                    {
                        ...this.form,
                        images: this.form.images
                            .split(",")
                            .map((url) => url.trim()),
                    }
                );
                const index = this.products.findIndex(
                    (p) => p.id === this.form.id
                );
                this.products[index] = response.data;
                this.filterProducts();
                this.closeModal();
            } catch (error) {
                console.error("Erro ao atualizar produto:", error);
            }
        },
        async deleteProduct(id) {
            if (confirm("Tem certeza que deseja excluir este produto?")) {
                try {
                    await axios.delete(`/api/products/${id}`);
                    this.products = this.products.filter(
                        (product) => product.id !== id
                    );
                    this.filterProducts();
                } catch (error) {
                    console.error("Erro ao excluir produto:", error);
                }
            }
        },
        formatCurrency(value) {
            return new Intl.NumberFormat("pt-BR", {
                style: "currency",
                currency: "BRL",
            }).format(value);
        },
        logout() {
            localStorage.removeItem("token");
            delete axios.defaults.headers.common["Authorization"];
            this.$router.push("/login");
        },
    },
    mounted() {
        this.fetchProducts();
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
    margin: 0;
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
    bottom: 0px;
    position: absolute;
    width: 100%;
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
