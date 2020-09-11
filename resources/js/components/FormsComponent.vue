<template>
    <div class="row mt">
        <div class="col-sm-12">
            <section class="panel">
                <header class="panel-heading wht-bg">
                    <h4 class="gen-case">
                        {{ config.title }}
                    </h4>
                </header>
                <div class="panel-body minimal">
                    <div role="form" class="form-horizontal style-form">
                        <div class="form-group" v-bind:class="{'has-error': errors[form.model]}" v-for="form in forms">
                            <label class="col-lg-2 control-label">{{ form.label }}
                                <span style="color: red;" v-if="form.mandatory">*</span>
                            </label>
                            <!--Select Option-->
                            <div class="col-lg-5" v-if="form.type == 'option'">
                                <select class="form-control select2" v-model="data[form.model]">
                                    <option value="" selected>--- Please Select ---</option>
                                    <option :value="data.value" v-for="data in form.data">
                                        {{ data.title }}
                                    </option>
                                </select>
                                <p class="help-block" v-if="errors[form.model]">{{errors[form.model][0] }}</p>
                            </div>
                            <!--TextArea-->
                            <div class="col-lg-5" v-else-if="form.type == 'textarea'">
                                <textarea class="form-control" v-model="data[form.model]"
                                          :placeholder="form.placeholder">
                                </textarea>
                                <p class="help-block" v-if="errors[form.model]">{{errors[form.model][0] }}</p>
                            </div>
                            <div class="col-lg-10" v-else>
                                <input :type="form.type ? form.type : 'text'" placeholder="" class="form-control" v-model="data[form.model]"
                                       :placeholder="form.placeholder" :disabled="form.disabled">
                                <p class="help-block" v-if="errors[form.model]">{{errors[form.model][0] }}</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <d-back-button/>
                                <button class="btn btn-theme" v-on:click="submitForm()">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</template>

<script>
    export default {
        props: ["forms", "config"],
        data() {
            return {
                data: {},
                errors: [],
                loadingSubmit: false,
                loading: false
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
            }
        },
    }
</script>

<style scoped>

</style>
