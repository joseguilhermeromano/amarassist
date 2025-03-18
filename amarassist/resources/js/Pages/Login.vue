<template>
    <div class="login-container">
        <div class="card">
            <div class="card-content">
                <img
                    src="/img/logo-amar-assist.png"
                    alt="Logo"
                    width="280"
                    height="120"
                    class="img-center"
                />
                <form @submit.prevent="handleLogin">
                    <!-- Mensagem de erro -->
                    <div v-if="errorMessage" class="error-message">
                        {{ errorMessage }}
                    </div>

                    <div class="input-field">
                        <i class="fas fa-user prefix"></i>
                        <input
                            id="email"
                            type="email"
                            class="custom-input"
                            v-model="email"
                            required
                            :disabled="loading"
                        />
                        <label for="email">E-mail</label>
                    </div>
                    <div class="input-field">
                        <i class="fas fa-lock prefix"></i>
                        <input
                            id="password"
                            type="password"
                            class="custom-input"
                            v-model="password"
                            required
                            :disabled="loading"
                        />
                        <label for="password">Senha</label>
                    </div>

                    <div class="center-align">
                        <button
                            type="submit"
                            class="btn waves-effect waves-light center-align"
                            :disabled="loading"
                        >
                            <LoadingSpinner v-if="loading" />
                            <span v-else>Entrar</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import LoadingSpinner from "@/components/LoadingSpinner.vue";

export default {
    components: {
        LoadingSpinner,
    },
    data() {
        return {
            email: "",
            password: "",
            errorMessage: "",
            loading: false,
        };
    },
    methods: {
        async handleLogin() {
            this.errorMessage = "";
            this.loading = true;

            try {
                const response = await axios.post("/api/login", {
                    email: this.email,
                    password: this.password,
                });

                localStorage.setItem("token", response.data.token);
                axios.defaults.headers.common[
                    "Authorization"
                ] = `Bearer ${response.data.token}`;

                this.$inertia.visit("/dashboard");
            } catch (error) {
                if (error.response && error.response.status === 401) {
                    this.errorMessage =
                        "Credenciais inválidas. Tente novamente.";
                } else {
                    this.errorMessage =
                        "Ocorreu um erro ao tentar fazer login. Tente novamente mais tarde.";
                }
            } finally {
                this.loading = false;
            }
        },
    },
};
</script>

<style lang="scss" scoped>
$blue-color: #621587;
$orange-color: #f36606;

.login-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background-color: #f5f5f5;

    .card {
        width: 100%;
        max-width: 400px;
        padding: 20px;
        border-radius: 10px;
        border: 2px solid $blue-color;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        display: flex;
        flex-direction: column;
        align-items: center;

        .error-message {
            color: red;
            font-size: 14px;
            text-align: center;
            background: #ffebee;
            padding: 8px;
            border-radius: 5px;
            width: 100%;
            margin-bottom: 10px;
        }

        .input-field {
            margin-bottom: 20px;

            .prefix {
                color: $blue-color;
            }

            input {
                border-bottom: 1px solid #ccc;
                &:focus {
                    border-bottom: 1px solid $blue-color;
                    box-shadow: 0 1px 0 0 $blue-color;
                }
            }

            input:focus + label {
                color: $blue-color;
            }

            label {
                color: $blue-color;
            }
        }

        .btn {
            font-family: "Nunito", sans-serif;
            font-weight: 400;
            background-color: $blue-color;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 40px;

            &:hover {
                background-color: $blue-color;
            }

            &:disabled {
                background-color: gray;
                cursor: not-allowed;
            }
        }
    }

    .center-align {
        margin: 0 auto;
    }
}
</style>
