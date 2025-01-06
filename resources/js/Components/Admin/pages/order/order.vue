<script>
   
    export default {
        data: function () {
            return {
                order: {},
                customer : {},
                ID: this.$route.params.id,
                status: ''
            }
        },
        methods: {
            async getOrder() {
                await axios.get("/api/orders/" + this.ID).then(res => {
                    this.order = res.data.order
                    this.status = this.order.status
                    this.customer = res.data.order.user
                    console.log(res.data)
                }).catch(err => {
                    console.log(err)
                })
            },
            async updateStatus() {

                let formData = new FormData()

                formData.append('status', this.status)
                formData.append('_method', 'PUT')

                await axios.post("/api/orders/" + this.ID + "/status", formData).then(res => {

                    Swal.fire({
                        title: 'Updated!',
                        text: 'Order Updated Successfully..!',
                        icon: 'success',
                        showCancelButton: true
                    })

                }).catch(err => {
                    console.log(err)
                })

            },
            formateDate(date) {
                return moment(date).format('MMMM Do YYYY, h:mm:ss a');
            },
            currency(value) {
                let val = (value / 1).toFixed(2).replace('.', ',')
                return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
            }
        },
        watch: {
            status: function (n, o) {
                if (o) {
                    this.updateStatus()
                }
            },
            ID: function () {
                this.getOrder()
            }
        },
        mounted() {

            this.getOrder()
            document.title = "Store | Order - " + this.ID

        }

    }

</script>

<template>
   
</template>


<style>

</style>
