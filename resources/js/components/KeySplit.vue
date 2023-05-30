<template>
    <div class="row mb-4">
        <div class="col">
            <div v-if="displayButton" class="card">
                <div class="card-body align-self-center">
                    <button class="btn btn-outline-dark my-5" @click="generate">Generate transport key</button>
                </div>
                <div v-if="errorMessage" class="card-footer">
                    {{ errorMessage }}
                </div>
            </div>
            <div v-else class="card">
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-6">
                            <h5 class="card-title font-weight-bold">Cryptogram</h5>
                            <p class="card-text">{{ cryptogram }}</p>
                        </div>
                        <div class="col-6">
                            <h5 class="card-title font-weight-bold">Transport key KCV</h5>
                            <p class="card-text">{{ kcv }}</p>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-12">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Component</th>
                                        <th scope="col">Component KCV</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(component, index) in components" :key="index">
                                        <th scope="row">{{ index + 1 }}</th>
                                        <td>{{ component.component }}</td>
                                        <td>{{ component.kcv }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-12">
                            <button class="btn btn-outline-dark" @click="generate">Generate transport key</button>
                            <button class="btn btn-dark ms-2" @click="reset">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue'

const props = defineProps({
    secretKey: {
        type: Object,
        required: true
    }
})

const cryptogram = ref('')
const kcv = ref('')
const components = ref({})
const displayButton = ref(true)
const errorMessage = ref('')

function generate() {
    errorMessage.value = ''

    axios
        .post('/api/admin/v1/transport_keys', {
            key: props.secretKey.key,
            bits: props.secretKey.bits,
        })
        .then(response => {
            cryptogram.value = response.data.cryptogram
            kcv.value = response.data.kcv
            components.value = response.data.components

            displayButton.value = false
        })
        .catch(error => {
            console.log(error.response);
            const status = [401, 403, 422]
            const defaultMessage = 'Transport key generation error'

            if (status.includes(error.response.status)) {
                errorMessage.value = error.response.data.message || defaultMessage
            } else {
                errorMessage.value = defaultMessage
            }
        })
}

function reset() {
    cryptogram.value = ''
    kcv.value = ''
    components.value = {}

    displayButton.value = true
}
</script>
