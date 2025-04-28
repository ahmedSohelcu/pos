<template>
    <div>
    <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">              
                <div class="col-md-12">                                                
                    <div class="mb-4 d-flex justify-content-between mb-2">                        
                        <div class="col me-3">
                            <select class="form-select customize-select" id="validationCustom04" required="">
                                <option selected="" disabled="" value="">Category</option>
                                <option>Electronics</option>
                                <option>Furniture</option>
                                <option>Cloth</option>
                            </select>
                            <div class="invalid-feedback">Please select a valid state.</div>
                        </div>

                        <!-- <div class="col me-3">
                            <select id="my-select" style="width: 100%">
                                <option value="1">Option 1</option>
                                <option value="2">Option 2</option>
                                <option value="3">Option 3</option>
                            </select>
                        </div> -->

                        <div class="col me-3">
                            <select class="form-select customize-select" id="validationCustom04" required="">
                                <option selected="" disabled="" value="">Brand</option>
                                <option>Apple</option>
                                <option>Samsung</option>
                               <option>Xiaomi</option>
                                <option>Lenevo</option>
                            </select>
                            <div class="invalid-feedback">Please select a valid state.</div>
                        </div>

                        <div class="col me-3">
                            <select class="form-select customize-select" id="validationCustom04" required="">
                                <option selected="" disabled="" value="">Brand</option>
                                <option>Apple</option>                                
                                <option>Xiaomi</option>
                                <option>Lenevo</option>
                            </select>
                            <div class="invalid-feedback">Please select a valid state.</div>
                        </div>

                        

                        <div class="offset-md-2 col-md-3">
                            <div class="input-group">
                                <input class="form-control customize-select" id="myInputDiv" type="text" placeholder="Search..">                                                                                               
                            </div>
                        </div>
                    </div>
                    <!-- /.card -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h3 class="card-title">Striped Full Width Table</h3>
                        </div>                        
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
                                    <td>Clean database</td>
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
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer clearfix">
                            <ul class="pagination pagination-sm m-0 float-end">
                                <li class="page-item"><a class="page-link" href="#">«</a></li>
                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><a class="page-link" href="#">»</a></li>
                            </ul>
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