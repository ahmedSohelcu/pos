<template>
    <div>
    <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">              
                <div class="col-md-12">
                    <!-- <h4 class="float-start mb-3">Manage Users</h4> -->
                    <div class="float-end mb-3">
                        <button type="button" class="btn btn-sm btn-success btn-icon float-end">
                            <span class="btn-inner--icon">
                                <i class="fas fa-download"></i>
                            </span>
                            <span class="btn-inner--text">&nbsp; Export Data</span>
                        </button>
                    </div>
                </div>

                <div class="col-md-12">                          
                    <div class="mb-3 d-flex justify-content-between mb-2">                        
                        <div class="col me-3">
                            <select class="form-select single-select-2" required="">
                                <option selected="" disabled="" value="">Category</option>
                                <option>Electronics</option>
                                <option>Furniture</option>
                                <option>Cloth</option>
                            </select>
                            <div class="invalid-feedback">Please select a valid state.</div>
                        </div>                        

                        <!-- <div class="col me-3">
                            <select class="col me-3 form-select scustomize-select multiple-select-2" name="states[]" multiple="multiple">
                                <option selected="" disabled="" value="">Brand</option>
                                    <option>Apple</option>
                                    <option>Samsung</option>
                                    <option>Xiaomi</option>
                                    <option>Lenevo</option>
                            </select>
                        </div> -->

                        <div class="col me-3">
                            <select class="col me-3 form-select customize-select single-select-2" name="states">
                                <option selected="" disabled="" value="">Select Phone</option>
                                    <option>Apple</option>
                                    <option>Samsung</option>
                                    <option>Xiaomi</option>
                                    <option>Lenevo</option>
                            </select>
                        </div>

                        <div class="col me-3">
                            <select class="form-select customize-select single-select-2" id="validationCustom04" required="">
                                <option selected="" disabled="" value="">Select Brand</option>
                                <option>Apple</option>                                
                                <option>Xiaomi</option>
                                <option>Lenevo</option>
                            </select>
                            <div class="invalid-feedback">Please select a valid state.</div>
                        </div>

                                            <!-- <select-option
                        :placeHolder="'select item'"
                        :width="500"
                        v-model="selectedItem"
                        :maxHeight="400"
                        :inputOutlineColor="'#86efac'"
                        :data="data"
                        :inputBorderColor="'gray'"
                        :displayName="'name'"
                        :selected="data[0]"
                        /> -->
                        

                        <div class="offset-md-2 col-md-3">
                            <div class="input-group">
                                <input class="form-control customize-select" id="myInputDiv" 
                                    type="text" placeholder="Search..">                                                                                               
                            </div>
                        </div>
                    </div>

                    <!-- /.card -->
                    <div class="card mb-4">
                        <!-- <div class="card-header">
                            <h3 class="card-title">Striped Full Width Table</h3>
                        </div>                         -->
                        <!-- /.card-header -->                      
                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Task</th>
                                    <th>Progress</th>
                                    <th style="width: 40px">Label</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr class="align-middle">
                                        <td>1.</td>
                                        <td>Update software</td>
                                        <td>
                                        <div class="progress progress-xs">
                                            <div class="progress-bar progress-bar-danger" style="width: 55%"></div>
                                        </div>
                                        </td>
                                        <td><span class="badge text-bg-danger">55%</span></td>
                                    </tr>
                                    <tr class="align-middle">
                                        <td>2.</td>
                                        <td><span class="badge text-bg-warning">70% amazing-unit-data</span></td>
                                        <td>
                                        <div class="progress progress-xs">
                                            <div class="progress-bar text-bg-warning" style="width: 70%"></div>
                                        </div>
                                        </td>
                                        <td><span class="badge text-bg-warning">70%</span></td>
                                    </tr>
                                    <tr class="align-middle">
                                        <td>3.</td>
                                        <td>Cron job running</td>
                                        <td>
                                        <div class="progress progress-xs progress-striped active">
                                            <div class="progress-bar text-bg-primary" style="width: 30%"></div>
                                        </div>
                                        </td>
                                        <td><span class="badge text-bg-primary">30%</span></td>
                                    </tr>
                                    <tr class="align-middle">
                                        <td>4.</td>
                                        <td>Fix and squish bugs</td>
                                        <td>
                                        <div class="progress progress-xs progress-striped active">
                                            <div class="progress-bar text-bg-success" style="width: 90%"></div>
                                        </div>
                                        </td>
                                        <td><span class="badge text-bg-success">90%</span></td>
                                    </tr>
                                    <tr class="align-middle">
                                        <td>5.</td>
                                        <td>Update software</td>
                                        <td>
                                        <div class="progress progress-xs">
                                            <div class="progress-bar progress-bar-danger" style="width: 55%"></div>
                                        </div>
                                        </td>
                                        <td><span class="badge text-bg-danger">55%</span></td>
                                    </tr>
                                    <tr class="align-middle">
                                        <td>6.</td>
                                        <td>Clean database</td>
                                        <td>
                                        <div class="progress progress-xs">
                                            <div class="progress-bar text-bg-warning" style="width: 70%"></div>
                                        </div>
                                        </td>
                                        <td><span class="badge text-bg-warning">70%</span></td>
                                    </tr>
                                    <tr class="align-middle">
                                        <td>7.</td>
                                        <td>Cron job running</td>
                                        <td>
                                        <div class="progress progress-xs progress-striped active">
                                            <div class="progress-bar text-bg-primary" style="width: 30%"></div>
                                        </div>
                                        </td>
                                        <td><span class="badge text-bg-primary">30%</span></td>
                                    </tr>
                                    <tr class="align-middle">
                                        <td>8.</td>
                                        <td>Fix and squish bugs</td>
                                        <td>
                                        <div class="progress progress-xs progress-striped active">
                                            <div class="progress-bar text-bg-success" style="width: 90%"></div>
                                        </div>
                                        </td>
                                        <td><span class="badge text-bg-success">90%</span></td>
                                    </tr>
                                    <tr class="align-middle">
                                        <td>9.</td>
                                        <td>Cron job running</td>
                                        <td>
                                        <div class="progress progress-xs progress-striped active">
                                            <div class="progress-bar text-bg-primary" style="width: 30%"></div>
                                        </div>
                                        </td>
                                        <td><span class="badge text-bg-primary">30%</span></td>
                                    </tr>
                                    <tr class="align-middle">
                                        <td>10.</td>
                                        <td>Fix and squish bugs</td>
                                        <td>
                                        <div class="progress progress-xs progress-striped active">
                                            <div class="progress-bar text-bg-success" style="width: 90%"></div>
                                        </div>
                                        </td>
                                        <td><span class="badge text-bg-success">90%</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        

                        <div class="card-footer clearfix">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <label>Show</label>
                                    <select class="form-select" style="width: 100px; display: inline-block; margin-left: 5px;">
                                        <option>10</option>
                                        <option>25</option>
                                        <option>50</option>
                                        <option>100</option>
                                    </select>
                                    <label class="mr-2">entries</label>
                                </div>

                                <ul class="pagination pagination-sm m-0">
                                    <li class="page-item"><a class="page-link" href="#">«</a></li>
                                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item"><a class="page-link" href="#">»</a></li>
                                </ul>
                            </div>
                        </div>


                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!--end::Row-->
        </div>
    <!--end::Container-->
    </div>
</template>

<script setup>
    import { onMounted, onBeforeUnmount } from 'vue';

    $(document).ready(function() {
        $('.single-select-2').select2();
        $('.multiple-select-2').select2();
    });

    $(document).ready(function() {
        $('.js-example-basic-multiple').select2();
    });

    // import $ from 'jquery';
    // // import 'select2/dist/css/select2.min.css';
    // import 'select2';
    
    // onMounted(() => {
    //     alert('...');
    //     $('#my-select').select2();
    // });

    // onBeforeUnmount(() => {
    //     $('#my-select').select2('destroy');
    // });
</script>

<style scoped>
    .customize-select {
        border-radius: 500px;
        text-align: center;
        color: #000;
    }
</style>   