<template>
    <v-app id="inspire">
        <v-form>
            <v-card>
                <v-card-title>
                    <span class="headline" v-if="this.$route.params.uuid">{{ 'Edit '+config.title }}</span>
                    <span class="headline" v-else>{{ 'Add '+config.title }}</span>
                </v-card-title>
                <v-card-text>
                    <v-container>
                        <v-row>
                            <v-col cols="12" md="4" v-for="form in forms" v-bind:key="form.model">
                                <!--                                DatePicker-->
                                <v-dialog
                                    ref="dialog"
                                    v-model="modal"
                                    :return-value.sync="date"
                                    persistent
                                    width="290px"
                                    v-if="form.type == 'datepicker'">
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-text-field
                                            v-model="data[form.model]"
                                            :label="form.label"
                                            prepend-icon="event"
                                            readonly
                                            v-bind="attrs"
                                            v-on="on"
                                        ></v-text-field>
                                    </template>
                                    <v-date-picker v-model="data[form.model]" scrollable>
                                        <v-spacer></v-spacer>
                                        <v-btn text color="primary" @click="modal = false">Cancel</v-btn>
                                        <v-btn text color="primary" @click="$refs.dialog.save(data[form.model])">OK
                                        </v-btn>
                                    </v-date-picker>
                                </v-dialog>
                                <!--                                Select Option-->
                                <v-autocomplete
                                    v-model="data[form.model]"
                                    :items="form.data"
                                    :label="form.label"
                                    :item-value="form.value"
                                    :item-text="form.text"
                                    v-else-if="form.type === 'option'">

                                </v-autocomplete>
                                <v-textarea
                                    v-model="data[form.model]"
                                    :label="form.label"
                                    v-else-if="form.type == 'textarea'"
                                >
                                </v-textarea>
                                <v-text-field
                                    v-model="data[form.model]"
                                    :rules="form.rules"
                                    :type="form.type ? form.type :'text'"
                                    :label="form.label"
                                    v-else></v-text-field>
                            </v-col>
                        </v-row>
                    </v-container>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <d-back-button/>
                    <div class="my-2">
                        <v-btn depressed color="primary" v-on:click="submitForm()">Submit</v-btn>
                    </div>
                </v-card-actions>
            </v-card>
        </v-form>
    </v-app>
</template>


<script>
    export default {
        props: ["forms", "config"],
        data() {
            return {
                data: {},
                errors: [],
                loadingSubmit: false,
                loading: false,
                modal: false,
            };
        },
        mounted() {
            this.getData();
        },
        methods: {
            async submitForm() {
                this.loadingSubmit = true;
                const payload = this.data;

                if (this.$route.params.uuid) {
                    this.data._method = "PATCH";
                }

                try {
                    const res = await axios.post(this.config.url + '/' + this.$route.params.uuid, payload);
                    Vue.swal({
                        icon: "success",
                        title: "Success!",
                        text: "Successfully Edit Data!"
                    }).then(next => {
                        window.history.length > 1 ? this.$router.go(-1) : this.$router.push('/');
                    });
                    console.log(res);
                } catch (e) {
                    this.errors = e.response.data.errors;
                    console.error(e.response.data);
                    this.loadingSubmit = false;
                }
            },
            getData() {
                if (this.$route.params.uuid) {
                    axios.get(this.config.url + '/' + this.$route.params.uuid).then(res => {
                        this.form = res.data;
                        console.log(res);
                    });
                }
            }
        },
    }
</script>

<style scoped>

</style>
