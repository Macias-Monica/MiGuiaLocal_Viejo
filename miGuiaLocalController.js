// miGuiaLocalController.js

new Vue({
    el: '#app', // Monta la instancia de Vue en el elemento con id "app"
    data: {
        negocios: [],
        categorias: [],
        isDropdownVisible: false,
        isCompact: false,                                                                                                                                                                                                                                                           // Controla la visibilidad del cuadro desplegable
        user: {
            nombreCompleto: '',
            usuario: '',
            contrasena: '',
            correo: '',
            telefono: ''
        },
        business: {
            nombreCompleto: '',
            nombreNegocio: '',
            categoria: '',
            usuario: '',
            contrasena: '',
            correo: '',
            telefono: ''
        },
          categoriaSeleccionada: ''
    },
    methods: {
        buscar() { //método que obtiene toda la informacion de la BD (Negocios y categorias)
            var t = this
            fetch(
                "miGuiaLocalModel.php?Cache=", {
                method: "POST",
                body: JSON.stringify({ tipo: 'buscar' })
            }
            ).then(function (response) {
                response
                    .json()
                    .then(function (json) {
                        console.log(json);
                        if (json.status == "OK") {
                            console.log(json)
                            t.negocios = json.negocios
                            t.categorias = json.categorias
                        }
                    })
                    .catch(function (err) {
                        console.log(err);
                    });
            });
        },
        toggleDropdown() {
            var t = this
            t.isDropdownVisible = !t.isDropdownVisible; // Alterna la visibilidad del cuadro desplegable
            // console.log(t.isDropdownVisible)
        },
        handleScroll() {
            this.isCompact = window.scrollY > 0; // Cambia el número según lo que necesites
        },
        register() {
            var t = this
            // Funcionalidad para registrarse
            data = {
                tipo: 'registraUsuario',
                info: t.user
            }
            console.log(data)

            fetch(
                "miGuiaLocalModel.php?Cache=", {
                method: "POST",
                body: JSON.stringify(data)
            }
            ).then(function (response) {
                response
                    .json()
                    .then(function (json) {
                        console.log(json);
                        if (json.status == "OK") {
                            console.log(json.message)
                        } else {
                            console.log(json.message)
                        }
                    })
                    .catch(function (err) {
                        console.log(err);
                    });
            });
        },
        login() {
            // Funcionalidad para iniciar sesión
            console.log('Iniciar sesión');
        },
        addNegocio() {
            var t = this
            // Funcionalidad para registrarse
            data = {
                tipo: 'registraNegocio',
                info: t.business
            }
            console.log(data)

            fetch(
                "miGuiaLocalModel.php?Cache=", {
                method: "POST",
                body: JSON.stringify(data)
            }
            ).then(function (response) {
                response
                    .json()
                    .then(function (json) {
                        console.log(json);
                        if (json.status == "OK") {
                            console.log(json.message)
                        } else {
                            console.log(json.message)
                        }
                    })
                    .catch(function (err) {
                        console.log(err);
                    });
            });
        },
        openModal(opc) {
            var t = this
            switch (opc) {
                case 1: //Abrir Modal del registro como usuario
                    modalElement = document.getElementById('registroUserModal');
                    break;
                case 2: //Abrir Modal de Registrar el negocio
                    modalElement = document.getElementById('registroNegocioModal');
                    break;
            }
            if (modalElement) {
                var modal = new bootstrap.Modal(modalElement);
                modal.show();
            }
        },
        scrollLeft() {
            this.$refs.carousel.scrollBy({ left: -200, behavior: 'smooth' });
        },
        scrollRight() {
            this.$refs.carousel.scrollBy({ left: 200, behavior: 'smooth' });
        },  
        elegirCategoria(cat){
            var t = this
            console.log(cat)
            t.categoriaSeleccionada = cat
        }
    },
    computed:{
        negociosFiltrados(){
            var t = this
            if (t.categoriaSeleccionada === '') {
                return t.negocios; // Muestra todos si no hay una categoría seleccionada
            }
            return t.negocios.filter(negocio => negocio.categoria === this.categoriaSeleccionada);
        }
    },
    mounted() {// cuando termina de cargar la página
        var t = this
        t.buscar()
        window.addEventListener('scroll', this.handleScroll);
    },
    created() { //mientras cargando la página

    },
    beforeDestroy() {
        window.removeEventListener('scroll', this.handleScroll);
    },

});