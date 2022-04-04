<template>
    <div>
        <form action="" method="POST" enctype="multipart/form-data">

            <div class="card border-light mt-3 shadow">
                <div class="card-header">
                    <h6 class="d-inline-block">Listed Product</h6>
                </div>

                <div class="card-body table-responsive">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><b>Date*</b></label>
                                <input type="date" class="form-control form-control-sm" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><b>Reference No</b></label>
                                <input type="text" class="form-control form-control-sm">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label><b>Status*</b></label>
                                <select name="supplier" class="form-control form-control-sm" required>
                                    <option value="Received">Received</option>
                                    <option value="Pending">Pending</option>
                                    <option value="Order">Order</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label><b>Attachments</b></label>
                                <input type="file" class="form-control form-control-sm">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label><b>Supplier*</b></label>
                                <select name="supplier" class="form-control form-control-sm" required>
                                    <option value="">Select supplier</option>
                                    <option v-for="user in users" :key="user.id" :value="user.id">{{user.last_name}}</option>

                                    <!-- @foreach ($users as $user)
                                        <option value="{{$user->id}}">{{$user->full_name}}</option>
                                    @endforeach -->
                                </select>
                            </div>
                        </div>
                    </div>

                    <br>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <h3>Seatch Product</h3>
                                <!-- <input type="text" class="form-control form-control-sm" placeholder="Search by Product name, id, sku code"> -->
                                <v-select :options="options" @search="onSearch"></v-select>
                            </div>
                        </div>
                    </div>

                    <table class="table table-bordered table-sm">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Image</th>
                            <th scope="col">Type</th>
                            <th scope="col">Variation</th>
                            <th scope="col">Tax</th>
                            <th scope="col">Discount</th>
                            <th scope="col" style="width: 120px">Unit Cost</th>
                            <th scope="col" style="width: 120px">Quantity</th>
                            <th scope="col" style="width: 120px">Subtotal</th>
                            <th scope="col" class="text-right"><i class="fas fa-trash"></i></th>
                        </tr>
                        </thead>
                        <tbody class="listed_items">
                        </tbody>
                    </table>

                    <div class="row">
                        <div class="col-md-4">

                        </div>
                    </div>

                    <div class="form-group">
                        <label><b>Note</b></label>
                        <textarea name="" cols="30" rows="5" class="form-control form-control-sm"></textarea>
                    </div>
                </div>

                <div class="card-footer">
                    <button class="btn btn-success">Submit</button>
                    <br>
                    <small><b>NB: *</b> marked are required field.</small>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
    import { mapActions, mapGetters } from 'vuex';

    export default {
        name: 'create-purchase',
        data: function () {
            return {
                options: []
            }
        },
        methods:{
            ...mapActions(['fetchUsers']),
            onSearch(search, loading) {
                console.log(search);
                // if(search.length) {
                    loading(true);
                //     this.search(loading, search, this);
                // }
            },
        },
        computed: {
            ...mapGetters(['users'])
        },
        created(){
            this.fetchUsers('supplier');
        }
    }
</script>
