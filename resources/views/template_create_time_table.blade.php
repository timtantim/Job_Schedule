@extends('layouts.app')
@push('styles')
<style>
/* .card-horizontal {
    display: flex;
    flex: 1 1 auto;
  } */

</style>
@endpush
@section('content')
    <div class="container-fluid" id="schedule_content">
        <div class="row">
            <div class="col">
                <div class="d-grid gap-2 d-md-block float-right">
                    <a class="btn btn-primary"  href="{{ url('/template_man_work')}}">新增頁面<i class="fa fa-share" aria-hidden="true"></i></a>
                </div>
            </div>
        </div>
       
        <div class="row">
          <div class="input-group mb-3 mt-1" style="width: 250px;">
            <span class="input-group-text" id="inputGroup-sizing-default">排班命名</span>
            <input type="text" class="form-control" aria-label="Sizing example input" id="time_table_name" aria-describedby="inputGroup-sizing-default">
          </div>
          <div class="input-group mb-3 mt-1" style="width: 300px;">
            <span class="input-group-text" id="inputGroup-sizing-default">日期區間</span>
            <input type="text" name="daterange" id="date_range"  />
            {{-- value="01/01/2018 - 01/15/2018" --}}
          </div>  
          <div class="input-group mb-3 mt-1" style="width: 350px;">
            <span class="input-group-text" id="inputGroup-sizing-default">人員預排樣板</span>
            <select class="form-control selectpicker" name="template_id" data-live-search="true" id="template_id"></select>
            <button class="btn btn-primary" onclick="btn_save()" type="button">建立</button>
          </div>
          <div class="input-group mb-3 mt-1" style="width: 250px;">
            <span class="input-group-text" id="inputGroup-sizing-default">工作班樣板名稱</span>
            <input type="text" class="form-control" aria-label="Sizing example input" readonly id="template_name" aria-describedby="inputGroup-sizing-default">
          </div>
          <div class="input-group mb-3 mt-1" style="width: 250px;">
            <span class="input-group-text" id="inputGroup-sizing-default">工作班樣板類型</span>
            <input type="text" class="form-control" aria-label="Sizing example input" readonly id="template_type" aria-describedby="inputGroup-sizing-default">
          </div>
        </div>
       
        <div id="week_container"></div>

  </div>
  <div class="modal modal-xl fade" id="humanResourceModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-xl " role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal" aria-label="Close"  style="width: 100%;">X</button>
        </div>
        <div class="modal-body">
          <div class="row" id="human_resource_container">

          </div>  

        </div>
      </div>
    </div>
  </div>

  <div class="modal modal-xl fade" id="presetWorkModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-xl " role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal" aria-label="Close"  style="width: 100%;">X</button>
        </div>
        <div class="modal-body">
          <div class="row" id="preset_work_container">

          </div>  

        </div>
      </div>
    </div>
  </div>
@endsection
@section('scripts')
<script src="{{ asset('js/Sortable.js') }}" defer></script>
<script src="{{ asset('js/prettify.js') }}" defer></script>
<script src="{{ asset('js/run_prettify.js') }}" defer></script>
<script src="{{ asset('js/list_drag_app.js') }}" defer></script>
<script type="text/javascript">

        var final_solution=[];
        let result_json_array=[];
        let temp_template=[];

        function btn_delete(){
          $.ajax({
                type: 'POST',
                data:{
                    'id':$('#template_id').val()  
                },
                url: api_url + '/api/delete_template',
                success: function(data) {
                    Swal.fire({
                        icon: 'success',
                        title: '註銷成功',
                        text: ''
                    });
                },
                error: function(xhr, status, error) {
                    let err = xhr.responseText;
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: err
                    });
                }
            });
        }
        // function min_human_resource(template_id,index,date,template_type){
        function min_human_resource(temp_template_index){
          // //這邊的index代表真實工作班的index ，並不是Template(因此要考慮單週循環跟雙週循環)
          // date=parseInt(date);
          // template_id=parseInt(template_id);
          // index=parseInt(index);
          // //雙週必須判斷是第一週還是第二週
          // if(template_type==14){
          //   if(index%template_type<7){
          //     if(date==0){
          //       date=7;
          //     }
          //   }else{
          //     if(date==0){
          //       date=14;
          //     }else{
          //       date+=7;
          //     }
          //   }
          // }else{
          //   if(date==0){
          //       date=7;
          //     }
          // }
          // let get_select_template=template_array.filter(n=>n.id==template_id);
          // let template_json= JSON.parse(get_select_template[0].template_json);
          // template_json=template_json.filter(n=>n.week_day==date)[0];
          let template_json=temp_template[temp_template_index];


          let min_doctor_array=[template_json.job_require.full_time_doctor_morning_shift,template_json.job_require.full_time_doctor_noon_shift,template_json.job_require.full_time_doctor_night_shift];
          let min_pharmacy_array=[template_json.job_require.full_time_pharmacist_morning_shift,template_json.job_require.full_time_pharmacist_noon_shift,template_json.job_require.full_time_pharmacist_night_shift];
          let min_nurse_array=[template_json.job_require.full_time_nurse_morning_shift,template_json.job_require.full_time_nurse_noon_shift,template_json.job_require.full_time_nurse_night_shift];
          let min_full_time_administration_array=[template_json.job_require.full_time_administration_staff_morning_shift,template_json.job_require.full_time_administration_staff_noon_shift,template_json.job_require.full_time_administration_staff_night_shift];
          let min_part_time_worker_array=[template_json.job_require.part_time_worker_morning_shift,template_json.job_require.part_time_worker_noon_shift,template_json.job_require.part_time_worker_night_shift];
          
          min_doctor=Math.max(...min_doctor_array);
          min_pharmacy=Math.max(...min_pharmacy_array);
          min_nurse=Math.max(...min_nurse_array);
          min_administration=Math.max(...min_full_time_administration_array);
          min_part_time_worker=Math.max(...min_part_time_worker_array);
          return {'min_doctor':min_doctor,'min_pharmacy':min_pharmacy,'min_nurse':min_nurse,'min_administration':min_administration,'min_part_time_worker':min_part_time_worker};
        }
        function preview_preset_work(template_id,index,date,template_type,temp_template_index){
          // date=parseInt(date);
          // template_id=parseInt(template_id);
          // index=parseInt(index);
          // //雙週必須判斷是第一週還是第二週
          // if(template_type==14){
          //   if(index%template_type<7){
          //     if(date==0){
          //       date=7;
          //     }
          //   }else{
          //     if(date==0){
          //       date=14;
          //     }else{
          //       date+=7;
          //     }
          //   }
          // }else{
          //   if(date==0){
          //       date=7;
          //     }
          // }
          // let get_select_template=template_array.filter(n=>n.id==template_id);
          // let template_json= JSON.parse(get_select_template[0].template_json);
          // template_json=template_json.filter(n=>n.week_day==date)[0];
          let template_json=temp_template[temp_template_index];
          $('#preset_work_container').empty();
          $('#preset_work_container').append(`
          
          <div class="card mt-2">
          <div class="card-horizontal">
              <div class="card-body">
                  <div class="row">
                    <div class="col-4">
                      <div class="row" id="duty_container_morning"></div>
                    </div>
                    <div class="col-4">
                      <div class="row" id="duty_container_noon"></div>
                    </div>
                    <div class="col-4">
                      <div class="row" id="duty_container_night"></div>
                    </div>
                  </div>
                  <div class="row">
                    <button class="btn btn-primary floar-right" onclick="update_preset_work(' ${temp_template_index}','${index}')"  type="button">更新</button> 
                  </div>
              </div>
          </div>
          <br>
          `);
          let induty_template_morning=employee_array.map(key => (
              `
              <input type="checkbox" id="in_duty_morning_${key.name}" name="in_duty_morning" value="${key.name}">
              <label class="form-check-label" for="in_duty_morning_${key.name}">
                ${key.name}
              </label>
              <br>`
          )).join('');

          let outduty_template_morning=employee_array.map(key => (
              `<input type="checkbox" id="out_duty_morning_${key.name}" name="out_duty_morning" value="${key.name}">
              <label class="form-check-label" for="out_duty_morning_${key.name}">
                ${key.name}
              </label>
              <br>`
          )).join('');

          ////////////////

          let induty_template_noon=employee_array.map(key => (
              `
              <input type="checkbox" id="in_duty_noon_${key.name}" name="in_duty_noon" value="${key.name}">
              <label class="form-check-label" for="in_duty_noon_${key.name}">
                ${key.name}
              </label>
              <br>`
          )).join('');
          let outduty_template_noon=employee_array.map(key => (
              `<input type="checkbox" id="out_duty_noon_${key.name}" name="out_duty_noon" value="${key.name}">
              <label class="form-check-label" for="out_duty_noon_${key.name}">
                ${key.name}
              </label>
              <br>`
          )).join('');

          ///////////////
          let induty_template_night=employee_array.map(key => (
              `
              <input type="checkbox" id="in_duty_night_${key.name}" name="in_duty_night" value="${key.name}">
              <label class="form-check-label" for="in_duty_night_${key.name}">
                ${key.name}
              </label>
              <br>`
          )).join('');
          let outduty_template_night=employee_array.map(key => (
              `<input type="checkbox" id="out_duty_night_${key.name}" name="out_duty_night" value="${key.name}">
              <label class="form-check-label" for="out_duty_night_${key.name}">
                ${key.name}
              </label>
              <br>`
          )).join('');

          //////////////   

          $(`#duty_container_morning`).append(`
              <div class="col-6 border-right"> 
                <h6 class="text-center">排入<i class="fa fa-sun-o" aria-hidden="true"></i></h6>
                  ${induty_template_morning}
              </div>
              <div class="col-6 border-right"> 
                <h6 class="text-center">不排入<i class="fa fa-sun-o" aria-hidden="true"></i></h6>
                  ${outduty_template_morning}   
              </div>   
          `);
          $(`#duty_container_noon`).append(`
              <div class="col-6 border-right"> 
                <h6 class="text-center">排入<i class="fa fa-spoon" aria-hidden="true"></i></h6>
                  ${induty_template_noon}
              </div>
              <div class="col-6 border-right"> 
                <h6 class="text-center">不排入<i class="fa fa-spoon" aria-hidden="true"></i></h6>
                  ${outduty_template_noon}   
              </div>
          `);
          $(`#duty_container_night`).append(`
              <div class="col-6 border-right"> 
                <h6 class="text-center">排入<i class="fa fa-moon-o" aria-hidden="true"></i></h6>
                  ${induty_template_night}
              </div>
              <div class="col-6 border-right"> 
                <h6 class="text-center">不排入<i class="fa fa-moon-o" aria-hidden="true"></i></h6>
                  ${outduty_template_night}   
              </div>
          `);

          for(let a=0;a<template_json.want_morning_shift.length;a++){
            $(`#in_duty_morning_${template_json.want_morning_shift[a]}`).prop('checked', true);
          } 
 
          for(let a=0;a<template_json.want_night_shift.length;a++){
            $(`#in_duty_night_${template_json.want_night_shift[a]}`).prop('checked', true);
          } 
 
          for(let a=0;a<template_json.want_noon_shift.length;a++){
            $(`#in_duty_noon_${template_json.want_noon_shift[a]}`).prop('checked', true);
          } 

          for(let a=0;a<template_json.dont_want_morning_shift.length;a++){
            $(`#out_duty_morning_${template_json.dont_want_morning_shift[a]}`).prop('checked', true);
          } 

          for(let a=0;a<template_json.dont_want_night_shift.length;a++){
            $(`#out_duty_night_${template_json.dont_want_night_shift[a]}`).prop('checked', true);
          } 

          for(let a=0;a<template_json.dont_want_noon_shift.length;a++){
            $(`#out_duty_noon_${template_json.dont_want_noon_shift[a]}`).prop('checked', true);
          } 

          $('#presetWorkModal').modal();
        }
        function update_preset_work(temp_template_index,index){
          temp_template_index=parseInt(temp_template_index);

          let in_duty_morning_array=$(`input[name=in_duty_morning]:checked`).map(function(){return this.value;}).get();
          let out_duty_morning_array=$(`input[name=out_duty_morning]:checked`).map(function(){return this.value;}).get();
        
          let in_duty_noon_array=$(`input[name=in_duty_noon]:checked`).map(function(){return this.value;}).get();
          let out_duty_noon_array=$(`input[name=out_duty_noon]:checked`).map(function(){return this.value;}).get();
        
          let in_duty_night_array=$(`input[name=in_duty_night]:checked`).map(function(){return this.value;}).get();
          let out_duty_night_array=$(`input[name=out_duty_night]:checked`).map(function(){return this.value;}).get();
          temp_template[temp_template_index].want_morning_shift=in_duty_morning_array;
          temp_template[temp_template_index].want_noon_shift=in_duty_noon_array;
          temp_template[temp_template_index].want_night_shift=in_duty_night_array;
          temp_template[temp_template_index].dont_want_morning_shift=out_duty_morning_array;
          temp_template[temp_template_index].dont_want_noon_shift=out_duty_noon_array;
          temp_template[temp_template_index].dont_want_night_shift=out_duty_night_array;
      
          Swal.fire({
              icon: 'success',
              title: '更新成功',
              text: ''
          });

         
          $('#presetWorkModal').modal('hide');
                  
        }
        function preview_human_resource(template_id,index,date,template_type,temp_template_index){
          //這邊的index代表真實工作班的index ，並不是Template(因此要考慮單週循環跟雙週循環)
          // date=parseInt(date);
          // template_id=parseInt(template_id);
          // index=parseInt(index);
          // //雙週必須判斷是第一週還是第二週
          // if(template_type==14){
          //   if(index%template_type<7){
          //     if(date==0){
          //       date=7;
          //     }
          //   }else{
          //     if(date==0){
          //       date=14;
          //     }else{
          //       date+=7;
          //     }
          //   }
          // }else{
          //   if(date==0){
          //       date=7;
          //     }
          // }
          // let get_select_template=template_array.filter(n=>n.id==template_id);
          // let template_json= JSON.parse(get_select_template[0].template_json);
          // template_json=template_json.filter(n=>n.week_day==date)[0];
          let template_json=temp_template[temp_template_index];

          $('#human_resource_container').empty();
          $('#human_resource_container').append(`
          
          <div class="card mt-2">
          <div class="card-horizontal">
              <div class="card-body">
                  <div class="row">
                    <div class="col-4">
                      <h5 class="text-center">早班</h5>
                          <div class="input-group mb-2">
                            <div class="input-group-prepend">
                              <span class="input-group-text" id="basic-addon1">醫師</span>
                            </div>
                            <input type="number" class="form-control input-append" id="full_time_doctor_morning_shift_human_resource" placeholder="填入所需人力" min='1' value="${template_json.job_require.full_time_doctor_morning_shift}">
                          </div>
                            <div class="input-group mb-2">
                          
                              <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">藥劑師</span>
                              </div>
                              <input type="number" class="form-control input-append" id="full_time_pharmacist_morning_shift_human_resource" placeholder="填入所需人力" min='1' value="${template_json.job_require.full_time_pharmacist_morning_shift}">
                            </div>
                            <div class="input-group mb-2">
                          
                              <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">護士</span>
                              </div>
                              <input type="number" class="form-control input-append" id="full_time_nurse_morning_shift_human_resource" placeholder="填入所需人力" min='1' value="${template_json.job_require.full_time_nurse_morning_shift}">
                            </div>
                            <div class="input-group mb-2">
                          
                              <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">行政人員</span>
                              </div>
                              <input type="number" class="form-control input-append" id="full_time_administration_staff_morning_shift_human_resource"  placeholder="填入所需人力" min='1' value="${template_json.job_require.full_time_administration_staff_morning_shift}">
                            </div>
                            <div class="input-group mb-2">
                          
                              <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">工讀生</span>
                              </div>
                              <input type="number" class="form-control input-append" id="part_time_worker_morning_shift_human_resource" placeholder="填入所需人力" min='1' value="${template_json.job_require.part_time_worker_morning_shift}">
                            </div>
                    </div>
                    <div class="col-4">
                      <h5 class="text-center">中班</h5>
                          <div class="input-group mb-2">
                            <div class="input-group-prepend">
                              <span class="input-group-text" id="basic-addon1">醫師</span>
                            </div>
                            <input type="number" class="form-control input-append" id="full_time_doctor_noon_shift_human_resource" placeholder="填入所需人力" min='1' value="${template_json.job_require.full_time_doctor_noon_shift}">
                          </div>
                            <div class="input-group mb-2">
                          
                              <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">藥劑師</span>
                              </div>
                              <input type="number" class="form-control input-append" id="full_time_pharmacist_noon_shift_human_resource" placeholder="填入所需人力" min='1' value="${template_json.job_require.full_time_pharmacist_noon_shift}">
                            </div>
                            <div class="input-group mb-2">
                          
                              <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">護士</span>
                              </div>
                              <input type="number" class="form-control input-append" id="full_time_nurse_noon_shift_human_resource" placeholder="填入所需人力" min='1' value="${template_json.job_require.full_time_nurse_noon_shift}">
                            </div>
                            <div class="input-group mb-2">
                          
                              <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">行政人員</span>
                              </div>
                              <input type="number" class="form-control input-append" id="full_time_administration_staff_noon_shift_human_resource"  placeholder="填入所需人力" min='1' value="${template_json.job_require.full_time_administration_staff_noon_shift}">
                            </div>
                            <div class="input-group mb-2">
                          
                              <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">工讀生</span>
                              </div>
                              <input type="number" class="form-control input-append" id="part_time_worker_noon_shift_human_resource" placeholder="填入所需人力" min='1' value="${template_json.job_require.part_time_worker_noon_shift}">
                            </div>
                    </div>
                    <div class="col-4">
                      <h5 class="text-center">晚班</h5>
                      <div class="input-group mb-2">
                            <div class="input-group-prepend">
                              <span class="input-group-text" id="basic-addon1">醫師</span>
                            </div>
                            <input type="number" class="form-control input-append" id="full_time_doctor_night_shift_human_resource" placeholder="填入所需人力" min='1' value="${template_json.job_require.full_time_doctor_night_shift}">
                          </div>
                            <div class="input-group mb-2">
                          
                              <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">藥劑師</span>
                              </div>
                              <input type="number" class="form-control input-append" id="full_time_pharmacist_night_shift_human_resource" placeholder="填入所需人力" min='1' value="${template_json.job_require.full_time_pharmacist_night_shift}">
                            </div>
                            <div class="input-group mb-2">
                          
                              <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">護士</span>
                              </div>
                              <input type="number" class="form-control input-append" id="full_time_nurse_night_shift_human_resource" placeholder="填入所需人力" min='1' value="${template_json.job_require.full_time_nurse_night_shift}">
                            </div>
                            <div class="input-group mb-2">
                          
                              <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">行政人員</span>
                              </div>
                              <input type="number" class="form-control input-append" id="full_time_administration_staff_night_shift_human_resource"  placeholder="填入所需人力" min='1' value="${template_json.job_require.full_time_administration_staff_night_shift}">
                            </div>
                            <div class="input-group mb-2">
                          
                              <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">工讀生</span>
                              </div>
                              <input type="number" class="form-control input-append" id="part_time_worker_night_shift_human_resource" placeholder="填入所需人力" min='1' value="${template_json.job_require.part_time_worker_night_shift}">
                            </div>
                    </div>
                  </div>
                  <div class="row">
                    <button class="btn btn-primary floar-right" onclick="update_human_resource(' ${temp_template_index}','${index}')"  type="button">更新</button> 
                  </div>
              </div>
          </div>
          </div>  
          <br>
      
          `);
          $('#humanResourceModal').modal();
        }
        function update_human_resource(temp_template_index,index){
          temp_template_index=parseInt(temp_template_index);
          // temp_template[temp_template_index].job_require
          temp_template[temp_template_index].job_require.full_time_administration_staff_morning_shift=$('#full_time_administration_staff_morning_shift_human_resource').val();
          temp_template[temp_template_index].job_require.full_time_administration_staff_night_shift=$('#full_time_administration_staff_night_shift_human_resource').val();
          temp_template[temp_template_index].job_require.full_time_administration_staff_noon_shift=$('#full_time_administration_staff_noon_shift_human_resource').val();
          temp_template[temp_template_index].job_require.full_time_doctor_morning_shift=$('#full_time_doctor_morning_shift_human_resource').val();
          temp_template[temp_template_index].job_require.full_time_doctor_night_shift=$('#full_time_doctor_night_shift_human_resource').val();
          temp_template[temp_template_index].job_require.full_time_doctor_noon_shift=$('#full_time_doctor_noon_shift_human_resource').val();
          temp_template[temp_template_index].job_require.full_time_nurse_morning_shift=$('#full_time_nurse_morning_shift_human_resource').val();
          temp_template[temp_template_index].job_require.full_time_nurse_night_shift=$('#full_time_nurse_night_shift_human_resource').val();
          temp_template[temp_template_index].job_require.full_time_nurse_noon_shift=$('#full_time_nurse_noon_shift_human_resource').val();
          temp_template[temp_template_index].job_require.full_time_pharmacist_morning_shift=$('#full_time_pharmacist_morning_shift_human_resource').val();
          temp_template[temp_template_index].job_require.full_time_pharmacist_night_shift=$('#full_time_pharmacist_night_shift_human_resource').val();
          temp_template[temp_template_index].job_require.full_time_pharmacist_noon_shift=$('#full_time_pharmacist_noon_shift_human_resource').val();
          temp_template[temp_template_index].job_require.part_time_worker_morning_shift=$('#part_time_worker_morning_shift_human_resource').val();
          temp_template[temp_template_index].job_require.part_time_worker_night_shift=$('#part_time_worker_night_shift_human_resource').val();
          temp_template[temp_template_index].job_require.part_time_worker_noon_shift=$('#part_time_worker_noon_shift_human_resource').val();

          Swal.fire({
              icon: 'success',
              title: '更新成功',
              text: ''
          });

          let limit_resource= min_human_resource(temp_template_index);
          $(`#day_off_container_description_doctor_${index}`).empty();
          $(`#day_off_container_description_doctor_${index}`).append(`
               <h6 class="text-center" id="human_limit_doctor_display_${index}"><i class="fa fa-calendar" aria-hidden="true"></i> 醫師排休 / <i class="fa fa-user" aria-hidden="true"></i> 人力: ${limit_resource.min_doctor}</h6><h6 style="display:none;" id="human_limit_doctor_${index}">${limit_resource.min_doctor}</h6>
          `);
          $(`#day_off_container_description_pharmacy_${index}`).empty();
          $(`#day_off_container_description_pharmacy_${index}`).append(`
               <h6 class="text-center" id="human_limit_pharmacy_display_${index}"><i class="fa fa-calendar" aria-hidden="true"></i> 藥師排休 / <i class="fa fa-user" aria-hidden="true"></i> 人力: ${limit_resource.min_pharmacy}</h6><h6 style="display:none;" id="human_limit_pharmacy_${index}">${limit_resource.min_pharmacy}</h6>
          `);
          $(`#day_off_container_description_nurse_${index}`).empty();
          $(`#day_off_container_description_nurse_${index}`).append(`
               <h6 class="text-center" id="human_limit_nurse_display_${index}"><i class="fa fa-calendar" aria-hidden="true"></i> 護士排休 / <i class="fa fa-user" aria-hidden="true"></i> 人力: ${limit_resource.min_nurse}</h6><h6 style="display:none;" id="human_limit_nurse_${index}">${limit_resource.min_nurse}</h6>
          `);
          $(`#day_off_container_description_administration_${index}`).empty();
          $(`#day_off_container_description_administration_${index}`).append(`
               <h6 class="text-center" id="human_limit_administration_display_${index}"><i class="fa fa-calendar" aria-hidden="true"></i> 行政排休 / <i class="fa fa-user" aria-hidden="true"></i> 人力: ${limit_resource.min_administration}</h6><h6 style="display:none;" id="human_limit_administration_${index}">${limit_resource.min_administration}</h6>
          `);
          $(`#day_off_container_description_part_time_worker_${index}`).empty();
          $(`#day_off_container_description_part_time_worker_${index}`).append(`
               <h6 class="text-center" id="human_limit_worker_display_${index}"><i class="fa fa-calendar" aria-hidden="true"></i> 工讀排休 / <i class="fa fa-user" aria-hidden="true"></i> 人力: ${limit_resource.min_part_time_worker}</h6><h6 style="display:none;" id="human_limit_worker_${index}">${limit_resource.min_part_time_worker}</h6>
          `);


          $('#humanResourceModal').modal('hide');
                  
        }
        function btn_save(){
          if($('#time_table_name').val()==''){
            Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: '排班名稱不可為空值'
                    });
                    return;
          }
    
          const concat = (...arrays) => [].concat(...arrays.filter(Array.isArray));
          let get_array=JSON.parse(template_array[0].template_json) 
          for(let i=0;i<temp_template.length;i++){
            let vacation_doctor_array=$(`input[name=vacation_doctor_${i}]:checked`).map(function(){return this.value;}).get();
            let vacation_pharmacy_array=$(`input[name=vacation_pharmacy_${i}]:checked`).map(function(){return this.value;}).get();
        
            let vacation_nurse_array=$(`input[name=vacation_nurse_${i}]:checked`).map(function(){return this.value;}).get();
            let vacation_administration_array=$(`input[name=vacation_administration_${i}]:checked`).map(function(){return this.value;}).get();
        
            let vacation_part_time_worker_array=$(`input[name=vacation_part_time_worker_${i}]:checked`).map(function(){return this.value;}).get();
          
            temp_template[i].day_off=concat(vacation_doctor_array, 
                                        vacation_pharmacy_array, 
                                        vacation_nurse_array, 
                                        vacation_administration_array,
                                        vacation_part_time_worker_array);
          }
          template_array[0].template_json=temp_template;
       
        $.ajax({
                type: 'POST',
                data:{
                    'date_range':$('#date_range').val(),
                    'time_table_name':$('#time_table_name').val(),
                    'job_json':JSON.stringify(template_array)
                },
                url: api_url + '/api/store_time_table',
                success: function(data) {
                    Swal.fire({
                        icon: 'success',
                        title: '更新成功',
                        text: ''
                    });
                    location.reload();
                },
                error: function(xhr, status, error) {
                    let err = xhr.responseText;
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: err
                    });
                }
            });
        }

        function load_template(id,dete_range){
            let get_select_template=template_array.filter(n=>n.id==id);
            let template_type=get_select_template[0].template_type;
            let template_json= JSON.parse(get_select_template[0].template_json) 
            $('#template_type').val((template_type==7)?'單週':'雙週');
            $('#template_job_duty_name').val($('#template_id option:selected') .text());
            $('#template_name').val(get_select_template[0].template_name);
            let week_day='';
            let date='';
            $('#week_container').empty();   

            for(let i=0;i<dete_range.length;i++){
              date=dete_range[i].getFullYear()+'/'+dete_range[i].getMonth()+'/'+dete_range[i].getDate();
             


              // 載入Temp到新的日期區間

              let temp_date=parseInt(dete_range[i].getDay());
              //雙週必須判斷是第一週還是第二週
              if(template_type==14){
                if(i%template_type<7){
                  if(temp_date==0){
                    temp_date=7;
                  }
                }else{
                  if(temp_date==0){
                    temp_date=14;
                  }else{
                    temp_date+=7;
                  }
                }
              }else{
                if(temp_date==0){
                  temp_date=7;
                }
              }
              let get_select_template=template_array.filter(n=>n.id==id);
              let template_json= JSON.parse(get_select_template[0].template_json);
              template_json=template_json.filter(n=>n.week_day==temp_date)[0];
              template_json=JSON.stringify(template_json);
              template_json=JSON.parse(template_json); 
              template_json.day_of_week=date;
              temp_template.push(template_json);
              // 載入Temp到新的日期區間

              // let min_human= min_human_resource(id,i,dete_range[i].getDay(),template_type);
              let min_human= min_human_resource(temp_template.length-1);
              switch(dete_range[i].getDay()){
                case 1:
                  week_day='星期一';
                break;
                case 2:
                  week_day='星期二';
                break;
                case 3:
                  week_day='星期三';
                break;
                case 4:
                  week_day='星期四';
                break;
                case 5:
                  week_day='星期五';
                break;
                case 6:
                  week_day='星期六';
                break;
                case 0:
                  week_day='星期日';
                break;
              }
              // <button class="btn btn-primary float-right" onclick="preview_human_resource(' ${id}','${i}','${dete_range[i].getDay()}','${template_type}')"  type="button">人力配置樣板 <i class="fa fa-street-view" aria-hidden="true"></i></button>             
              $('#week_container').append(`
          
                    <div class="card mt-2">
                    <div class="card-horizontal">
                        <div class="card-header" >
                          <div class="row">
                            <div class="col-6">
                              <h4 class="align-self-center">${week_day}(${date})</h4> 
                            </div>
                            <div class="col-6">
                              <button class="btn btn-primary float-right ml-1" onclick="preview_preset_work(' ${id}','${i}','${dete_range[i].getDay()}','${template_type}','${temp_template.length-1}')"  type="button">人員預排樣板 <i class="fa fa-street-view" aria-hidden="true"></i></button>             
                              <button class="btn btn-primary float-right" onclick="preview_human_resource(' ${id}','${i}','${dete_range[i].getDay()}','${template_type}','${temp_template.length-1}')"  type="button">人力配置樣板 <i class="fa fa-street-view" aria-hidden="true"></i></button>             
                            </div>
                          </div> 
                        </div>
                        <div class="card-body">
                            <div class="row">
                              <div class="col-3 border-right">
                                <div class="row" id="day_off_container_doctor_${i}">
                                  <div id="day_off_container_description_doctor_${i}">
                                        <h6 class="text-center" id="human_limit_doctor_display_${i}"><i class="fa fa-calendar" aria-hidden="true"></i> 醫師排休 / <i class="fa fa-user" aria-hidden="true"></i> 人力: ${min_human.min_doctor}</h6><h6 style="display:none;" id="human_limit_doctor_${i}">${min_human.min_doctor}</h6>
                                  </div>
                                </div>
                              </div>
                              <div class="col-3 border-right">
                                <div class="row" id="day_off_container_pharmacy_${i}">
                                  <div id="day_off_container_description_pharmacy_${i}">
                                        <h6 class="text-center" id="human_limit_pharmacy_display_${i}"> <i class="fa fa-calendar" aria-hidden="true"></i> 藥師排休 / <i class="fa fa-user" aria-hidden="true"></i> 人力: ${min_human.min_pharmacy}</h6><h6 style="display:none;" id="human_limit_pharmacy_${i}">${min_human.min_pharmacy}</h6>
                                  </div>
                                </div>
                              </div>
                              <div class="col-2 border-right">
                                <div class="row" id="day_off_container_nurse_${i}">
                                  <div id="day_off_container_description_nurse_${i}">
                                    <h6 class="text-center" id="human_limit_nurse_display_${i}"><i class="fa fa-calendar" aria-hidden="true"></i> 護士排休 / <i class="fa fa-user" aria-hidden="true"></i> 人力: ${min_human.min_nurse}</h6><h6 style="display:none;" id="human_limit_nurse_${i}">${min_human.min_nurse}</h6>
                                  </div>
                                </div>
                              </div>
                              <div class="col-2 border-right">
                                <div class="row" id="day_off_container_administration_${i}">
                                  <div id="day_off_container_description_administration_${i}">
                                    <h6 class="text-center" id="human_limit_administration_display_${i}"><i class="fa fa-calendar" aria-hidden="true"></i> 行政排休 / <i class="fa fa-user" aria-hidden="true"></i> 人力: ${min_human.min_administration}</h6><h6 style="display:none;" id="human_limit_administration_${i}">${min_human.min_administration}</h6>
                                  </div>
                                </div>
                              </div>
                              <div class="col-2 border-right">
                                <div class="row" id="day_off_container_part_time_worker_${i}">
                                  <div id="day_off_container_description_part_time_worker_${i}">
                                    <h6 class="text-center" id="human_limit_worker_display_${i}"><i class="fa fa-calendar" aria-hidden="true"></i> 工讀排休 / <i class="fa fa-user" aria-hidden="true"></i> 人力: ${min_human.min_part_time_worker}</h6><h6 style="display:none;" id="human_limit_worker_${i}">${min_human.min_part_time_worker}</h6>
                                  </div>
                                </div>
                              </div>
                            </div>
                        </div>
                    </div>
                    <br>
                
                    `);
                    let vacation_doctor=employee_array.filter(n=>n.position=='醫師').map(key => (
                        `
                        <div class="col-1"> 
                          <input type="checkbox" class="doctor_checkbox doctor_class_${i}" id="vacation_doctor_${key.name}_${i}" name="vacation_doctor_${i}" value="${key.name}">
                          <label class="form-check-label" for="vacation_doctor_${key.name}_${i}">
                            ${key.name}<h4 style="margin-left:3px;margin-bottom: 0px;">&#8226;</h4>${key.position_type}
                          </label>
                        </div> 
                        `
                    )).join('');
                    $(`#day_off_container_doctor_${i}`).append(`${vacation_doctor}`);
                    let vacation_pharmacy=employee_array.filter(n=>n.position=='藥劑師').map(key => (
                        `
                        <div class="col-1"> 
                          <input type="checkbox" class="pharmacy_checkbox pharmacy_class_${i}" id="vacation_pharmacy_${key.name}_${i}" name="vacation_pharmacy_${i}" value="${key.name}">
                          <label class="form-check-label" for="vacation_pharmacy_${key.name}_${i}">
                            ${key.name}<h4 style="margin-left:3px;margin-bottom: 0px;">&#8226;</h4>${key.position_type}
                          </label>
                        </div> 
                        `
                    )).join('');
                    $(`#day_off_container_pharmacy_${i}`).append(`${vacation_pharmacy}`);
                    let vacation_nurse=employee_array.filter(n=>n.position=='護士').map(key => (
                        `
                        <div class="col-1"> 
                          <input type="checkbox"  class="nurse_checkbox nurse_class_${i}" id="vacation_nurse_${key.name}_${i}" name="vacation_nurse_${i}" value="${key.name}">
                          <label class="form-check-label" for="vacation_nurse_${key.name}_${i}">
                            ${key.name}<h4 style="margin-left:3px;margin-bottom: 0px;">&#8226;</h4>${key.position_type}
                          </label>
                        </div> 
                        `
                    )).join('');
                    $(`#day_off_container_nurse_${i}`).append(`${vacation_nurse}`);
                    let vacation_administration=employee_array.filter(n=>n.position=='行政').map(key => (
                        `
                        <div class="col-1"> 
                          <input type="checkbox" class="administration_checkbox administration_class_${i}" id="vacation_administration_${key.name}_${i}" name="vacation_administration_${i}" value="${key.name}">
                          <label class="form-check-label" for="vacation_administration_${key.name}_${i}">
                            ${key.name}<h4 style="margin-left:3px;margin-bottom: 0px;">&#8226;</h4>${key.position_type}
                          </label>
                        </div> 
                        `
                    )).join('');
                    $(`#day_off_container_administration_${i}`).append(`${vacation_administration}`);
                    let vacation_part_time_worker=employee_array.filter(n=>n.position=='工讀').map(key => (
                        `
                        <div class="col-1"> 
                          <input type="checkbox" class="part_time_worker_checkbox part_time_worker_class_${i}" id="vacation_part_time_worker_${key.name}_${i}" name="vacation_part_time_worker_${i}" value="${key.name}">
                          <label class="form-check-label" for="vacation_part_time_worker_${key.name}_${i}">
                            ${key.name}
                          </label>
                        </div> 
                        `
                    )).join('');
                    $(`#day_off_container_part_time_worker_${i}`).append(`${vacation_part_time_worker}`);
              }  
            }

        function load_employee(){
          
          $.ajax({
                type: 'POST',
                url: api_url + '/api/load_employee',
                success: function(data) {
                  employee_array=data;
                },
                error: function(xhr, status, error) {
                    let err = xhr.responseText;
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: err
                    });
                }
            });
        }

        function load_template_api(){
          
          $.ajax({
                type: 'POST',
                url: api_url + '/api/load_template_job_duty',
                success: function(data) {
                  template_array=data;
                  $('#template_id').append(`<option value="choose">請選擇人力預排樣板</option>`);
                          for(let i=0;i<data.length;i++){
                            $('#template_id').append(`<option value="${data[i].id}">${data[i].template_job_duty_name}</option>`);
                          }
                          $('#template_id').selectpicker('refresh');
                },
                error: function(xhr, status, error) {
                    let err = xhr.responseText;
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: err
                    });
                }
            });
        }
        Date.prototype.addDays = function(days) {
            var date = new Date(this.valueOf());
            date.setDate(date.getDate() + days);
            return date;
        }
        function checkbox_event(){
                $('.doctor_checkbox').click(function() {
                    let checkbox_id= $(this).attr('id');
                    let get_array=checkbox_id.split('_');
                    let get_index=get_array[get_array.length-1];
                    let get_position=get_array[get_array.length-3];  
                    let total_human_source= parseInt($(`.doctor_class_${get_index}`).length); 
                    let limit= parseInt($(`#human_limit_doctor_${get_index}`).text());
                    let check_quantity= $(`input[name=vacation_doctor_${get_index}]:checked`).map(function(){return this.value;}).get().length;

                    if(total_human_source-check_quantity<limit){
                      Swal.fire({
                        icon: 'warning',
                        text: '休假人數超過人力配置數量!'
                      });
                      $(`#${checkbox_id}`).prop('checked',false);
                    }
                });
                $('.pharmacy_checkbox').click(function() {
                  let checkbox_id= $(this).attr('id');
                    let get_array=checkbox_id.split('_');
                    let get_index=get_array[get_array.length-1];
                    let get_position=get_array[get_array.length-3];  
                    let total_human_source= parseInt($(`.pharmacy_class_${get_index}`).length); 
                    let limit= parseInt($(`#human_limit_pharmacy_${get_index}`).text());
                    let check_quantity= $(`input[name=vacation_pharmacy_${get_index}]:checked`).map(function(){return this.value;}).get().length;

                    if(total_human_source-check_quantity<limit){
                      Swal.fire({
                        icon: 'warning',
                        text: '休假人數超過人力配置數量!'
                      });
                      $(`#${checkbox_id}`).prop('checked',false);
                    }
                });
                $('.nurse_checkbox').click(function() {
                  let checkbox_id= $(this).attr('id');
                    let get_array=checkbox_id.split('_');
                    let get_index=get_array[get_array.length-1];
                    let get_position=get_array[get_array.length-3];  
                    let total_human_source= parseInt($(`.nurse_class_${get_index}`).length); 
                    let limit= parseInt($(`#human_limit_nurse_${get_index}`).text());
                    let check_quantity= $(`input[name=vacation_nurse_${get_index}]:checked`).map(function(){return this.value;}).get().length;

                    if(total_human_source-check_quantity<limit){
                      Swal.fire({
                        icon: 'warning',
                        text: '休假人數超過人力配置數量!'
                      });
                      $(`#${checkbox_id}`).prop('checked',false);
                    }
                });
                $('.administration_checkbox').click(function() {
                  let checkbox_id= $(this).attr('id');
                    let get_array=checkbox_id.split('_');
                    let get_index=get_array[get_array.length-1];
                    let get_position=get_array[get_array.length-3];  
                    let total_human_source= parseInt($(`.administration_class_${get_index}`).length); 
                    let limit= parseInt($(`#human_limit_administration_${get_index}`).text());
                    let check_quantity= $(`input[name=vacation_administration_${get_index}]:checked`).map(function(){return this.value;}).get().length;

                    if(total_human_source-check_quantity<limit){
                      Swal.fire({
                        icon: 'warning',
                        text: '休假人數超過人力配置數量!'
                      });
                      $(`#${checkbox_id}`).prop('checked',false);
                    }
                });
                $('.part_time_worker_checkbox').click(function() {
                  let checkbox_id= $(this).attr('id');
                    let get_array=checkbox_id.split('_');
                    let get_index=get_array[get_array.length-1];
                    let get_position=get_array[get_array.length-3];  
                    let total_human_source= parseInt($(`.part_time_worker_class_${get_index}`).length); 
                    let limit= parseInt($(`#human_limit_worker_${get_index}`).text());
                    let check_quantity= $(`input[name=vacation_part_time_worker_${get_index}]:checked`).map(function(){return this.value;}).get().length;

                    if(total_human_source-check_quantity<limit){
                      Swal.fire({
                        icon: 'warning',
                        text: '休假人數超過人力配置數量!'
                      });
                      $(`#${checkbox_id}`).prop('checked',false);
                    }
                });
        }

        function getDates(startDate, stopDate) {
            var dateArray = new Array();
            var currentDate = startDate;
            while (currentDate <= stopDate) {
                dateArray.push(new Date (currentDate));
                currentDate = currentDate.addDays(1);
            }
            return dateArray;
        }
        $( document ).ready(function() {
          let template_array;
          let employee_array;
            // load_template();
            load_employee();
            load_template_api();
            $('#template_id').on('change',function(){
              let pattern = /(\d{2})\.(\d{2})\.(\d{4})/;
              let date_one = new Date($('#date_range').val().split('-')[0].trim().replace(pattern,'$3-$2-$1'));
              let date_two = new Date($('#date_range').val().split('-')[1].trim().replace(pattern,'$3-$2-$1'));
              let date_array=getDates(date_one,date_two);
              if(date_array.length<=1){
                Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: '請輸入工作班日期'
                    });
                    return;
              }
                load_template($('#template_id').val(),date_array);
                checkbox_event();
            });


            $('input[name="daterange"]').daterangepicker({
              opens: 'left'
            }, function(start, end, label) {
              console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
            });
       

        });
</script>
@endsection

