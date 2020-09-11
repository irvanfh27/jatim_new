<template>
    <v-app id="inspire">
        <v-form v-model="valid">
            <v-card>
                <v-card-title>
                    <span class="headline">{{ config.title }}</span>
                </v-card-title>
                <v-card-text>
                    <v-container>
                        <v-row>
                            <v-col cols="12" md="4" v-for="form in forms">
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
                                <v-autocomplete
                                    :items="form.data"
                                    :label="form.label"
                                    :item-value="form.value"
                                    :item-text="form.text"
                                    v-else-if="form.type === 'select-option'"></v-autocomplete>
                                <v-text-field
                                    v-model="data[form.model]"
                                    :rules="form.rules"
                                    :type="form.type ? form.type :'text'"
                                    :label="form.label"
                                    v-else></v-text-field>
                            </v-col>

                            <v-col cols="12" sm="6">
                                <v-dialog v-model="dialog" persistent max-width="600px">
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-btn
                                            color="warning"
                                            dark
                                            v-bind="attrs"
                                            v-on="on"
                                        >
                                            Add Data
                                        </v-btn>
                                    </template>
                                    <v-card>
                                        <v-card-title>
                                            <span class="headline">User Profile</span>
                                        </v-card-title>
                                        <v-card-text>
                                            <v-container>
                                                <v-row>
                                                    <v-col cols="12" sm="6" md="4">
                                                        <v-text-field label="Legal first name*" required></v-text-field>
                                                    </v-col>
                                                    <v-col cols="12" sm="6" md="4">
                                                        <v-text-field label="Legal middle name"
                                                                      hint="example of helper text only on focus"></v-text-field>
                                                    </v-col>
                                                    <v-col cols="12" sm="6" md="4">
                                                        <v-text-field
                                                            label="Legal last name*"
                                                            hint="example of persistent helper text"
                                                            persistent-hint
                                                            required
                                                        ></v-text-field>
                                                    </v-col>
                                                    <v-col cols="12">
                                                        <v-text-field label="Email*" required></v-text-field>
                                                    </v-col>
                                                    <v-col cols="12">
                                                        <v-text-field label="Password*" type="password"
                                                                      required></v-text-field>
                                                    </v-col>
                                                    <v-col cols="12" sm="6">
                                                        <v-select
                                                            :items="['0-17', '18-29', '30-54', '54+']"
                                                            label="Age*"
                                                            required
                                                        ></v-select>
                                                    </v-col>
                                                    <v-col cols="12" sm="6">
                                                        <v-autocomplete
                                                            :items="['Skiing', 'Ice hockey', 'Soccer', 'Basketball', 'Hockey', 'Reading', 'Writing', 'Coding', 'Basejump']"
                                                            label="Interests"
                                                            multiple
                                                        ></v-autocomplete>
                                                    </v-col>
                                                </v-row>
                                            </v-container>
                                            <small>*indicates required field</small>
                                        </v-card-text>
                                        <v-card-actions>
                                            <v-spacer></v-spacer>
                                            <v-btn color="blue darken-1" text @click="dialog = false">Close</v-btn>
                                            <v-btn color="blue darken-1" text @click="dialog = false">Save</v-btn>
                                        </v-card-actions>
                                    </v-card>
                                </v-dialog>

                            </v-col>
                        </v-row>
                    </v-container>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <div class="my-2">
                        <v-btn depressed>Back</v-btn>
                    </div>
                    <div class="my-2">
                        <v-btn depressed color="primary">Submit</v-btn>
                    </div>
                </v-card-actions>
            </v-card>
        </v-form>
    </v-app>
</template>


<script>
    export default {
        props: ['config', 'forms'],
        name: "CreatePO",
        data() {
            return {
                dialog: false,
                data: {},
                errors: [],
                loadingSubmit: false,
                loading: false,
                valid: false,
                modal: false,
                model: null,
                item: true,
                items: [
                    'Test', 'asd'
                ],
                firstname: '',
                lastname: '',
                date: new Date().toISOString().substr(0, 10),
                menu1: false,
                menu2: false,
                nameRules: [
                    v => !!v || 'Name is required',
                    v => v.length <= 10 || 'Name must be less than 10 characters',
                ],
                email: '',
                emailRules: [
                    v => !!v || 'E-mail is required',
                    v => /.+@.+/.test(v) || 'E-mail must be valid',
                ],
            };
        },
        methods: {
            async submitForm() {
                this.loadingSubmit = true;
                const payload = this.data;
                try {
                    const res = await axios.post(this.config.url, payload);
                    Vue.swal({
                        icon: "success",
                        title: "Success!",
                        text: "Successfully Insert Data!"
                    }).then(next => {
                        window.history.length > 1 ? this.$router.go(-1) : this.$router.push('/');
                    });
                    console.log(res);
                    // console.log(config.url);
                } catch (e) {
                    this.errors = e.response.data.errors;
                    console.error(e.response.data);
                    this.loadingSubmit = false;
                }
            },
        },
    }
</script>

<style scoped>

</style>
