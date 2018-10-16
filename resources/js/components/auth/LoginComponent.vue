<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">{{title}}</div>

                    <div class="card-body">
                    <form class="form-horizontal" role="form">

                        <div class="form-group row" :class="{'has-error' : errorsEmail}">
                            <label for="email" class="col-sm-4 col-form-label text-md-right">Email</label>

                            <div class="col-md-6">
                                <input id="email" 
                                    type="email"
                                    :class="{'is-invalid':errorsEmail, 'form-control': true}"
                                    v-model="loginDetails.email" 
                                    required autofocus />

                                <span v-if="errorsEmail" class="invalid-feedback" role="alert">
                                    <strong>{{emailError}}</strong>
                                </span>
                            
                            </div>
                        </div>

                        <div class="form-group row" :class="{'has-error' : errorsEmail}">
                            <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                            <div class="col-md-6">
                                <input id="password" 
                                    type="password" 
                                    :class="{'is-invalid':errorsEmail, 'form-control': true}"
                                    v-model="loginDetails.password"
                                    required />
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" v-model="loginDetails.remember" id="remember">

                                    <label class="form-check-label" for="remember">
                                        Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" @click.prevent="logIn" class="btn btn-primary">
                                    Login
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            title: String,
            action: String,
        },
        data () {
            return {
                loginDetails: {
                    email: '',
                    password: '',
                    remember: false,
                },
                errorsEmail: false,
                emailError:null,
            }
        },
        methods: {
            logIn () {
                let vm = this;
                axios.post(vm.action, vm.loginDetails)
                .then(function(success) {
                    
                    console.log(success);
                    if(success.statusText === 'OK') {
                    
                        // username and password match
                        // redirect user to home screen
                        window.location = '/home';
                    }
                })
                .catch(function(error) {
                    
                    var errors = error.response
                    if(errors && errors.status === 422 
                              && errors.statusText === 'Unprocessable Entity'){
                        
                        if(errors.data){
                            var em = errors.data.errors.email;
                            if(em.length > 0){
                            vm.errorsEmail = true
                            vm.emailError = _.isArray(em) ? em[0]: em
                            }
                        }
                    }
                });
            }
        }
    }
</script>
