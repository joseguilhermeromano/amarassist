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
                    <div class="input-field">
                        <i class="fas fa-user prefix"></i>
                        <input
                            id="email"
                            type="email"
                            class="custom-input"
                            v-model="email"
                            required
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
                        />
                        <label for="password">Senha</label>
                    </div>
                    <div class="center-align">
                        <button
                            type="submit"
                            class="btn waves-effect waves-light"
                        >
                            Entrar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            email: "",
            password: "",
        };
    },
    methods: {
        handleLogin() {
            this.$inertia.visit("/dashboard");
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
        flex-direction: row;
        align-items: center;
        justify-content: center;

        h4 {
            color: #333;
            margin-bottom: 20px;
            font-family: "Nunito", sans-serif;
            font-weight: 400;
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
            &:hover {
                background-color: $blue-color;
            }
        }
    }
}
</style>
