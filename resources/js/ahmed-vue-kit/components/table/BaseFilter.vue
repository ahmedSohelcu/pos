<template>
    <!-- filter start -->
    <div v-if="filters.length" class="container-fluid">
        <div class="card card-outline card-success mb-4">
            <div class="card-body">
                <div class="container-fluid">
                    <div class="row">              
                        <div class="col-md-12">
                            <h4 class="float-start mb-3">Filters Data</h4> 
                        </div>

                        <div class="col-md-12">                          
                            <div class="mb-3 d-flex Sjustify-content-between mb-2">                                                                    
                                <div v-for="(filter, index) in filters" :class="[filters.length > 3 ? 'col' : 'col-md-4','mb-3']">                                   
                                    <!-- 01. if select option -->
                                    <BaseSelect
                                        v-if="filter.type === 'select'"
                                        v-model="form[filter.name]"
                                        :name="filter.name"
                                        :getApiRoute="filter.getApiRoute"
                                        :options="filter.options"
                                        :optionKeyName="filter.optionKeyName"
                                        :label="filter.label"
                                        :placeholder="`Choose ${filter.label}`"
                                        :select2="filter.select2 || false"      
                                        :multiple="filter.multiple || false"                                        
                                    />

                                    <!--02.  if not select option (date picker) -->
                                    <!-- // may be select , time, date, datetime, datetimerange                                         -->
                                    <BaseDatePicker 
                                        v-if="filter.type !== 'select'"
                                        v-model="form[filter.name]"
                                        :label="filter.label"
                                        :placeholder="`Choose ${filter.label}`"
                                        :type="filter.type"
                                        :name="filter.name"
                                    />
                                </div>                                         
                                <!-- <div class="col me-0 mt-4">
                                    <button class="btn btn-sm btn-primary w-50">
                                        Filter
                                    </button>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- filters end -->   
</template>

<script setup>
    import { reactive, watch } from 'vue'
    import { route } from 'ziggy-js'

    const props = defineProps({       
        filters: {
            type: Array,
            required: true,
            // Example: [{ name: 'name', label: 'Name', width: '150px' }, ...]
        } 
    })

    // define emits
    const emit = defineEmits(['filter-change'])

    // reactive object to hold filter values dynamically
    const form = reactive({})
    
    watch(
        () => props.filters,
        (newFilters) => {
            newFilters.forEach(f => {
                if (f.multiple) {
                    form[f.name] = f.default || []
                } else {
                    form[f.name] = f.default || ''
                }
            })
        },
        { immediate: true }
    )


    // watch for changes and emit
    watch(
        () => JSON.stringify(form),
        () => {
            emit('filter-change', { ...form })
        }
    )

    console.log('form', form);
</script>
<!--

//-----------------
How to use
//-----------------
const filters = [
  {
      name: 'status_id',
      label: 'Select Status',
      type: 'select',
      options: [
          { id: 1, type: 'active'},
          { id: 2, type: 'inactive'},
      ],
      optionKeyName: 'type', //like type, name, etc default name
  },
  {
      name: 'created_at',
      label: 'Created Date',
      type: 'date'
  },
  {
      name: 'time',
      label: 'Time',
      type: 'time'
  },
  // {
  //     name: 'Date',
  //     label: 'created At',
  //     type: 'datetime'
  // },
  // {
  //     name: 'date_range',
  //     label: 'Date Range',
  //     type: 'datetimerange'
  // },


** Support types: select, date, time, datetime, datetimerange
** type is select for all kinds of select optino dropdown
and for date picker type is date, time, datetime, datetimerange

];
-->