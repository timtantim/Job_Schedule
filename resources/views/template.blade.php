@extends('layouts.app')
@push('styles')
<style>
.card-horizontal {
    display: flex;
    flex: 1 1 auto;
  }
</style>
@endpush
@section('content')
    <div class="container-fluid" id="schedule_content">
        <div class="row">
            <div class="col">
                <div class="d-grid gap-2 d-md-block float-right">
                    {{-- <button class="btn btn-primary" type="button">查詢頁面<i class="fa fa-share" aria-hidden="true"></i></button> --}}
                    <a class="btn btn-primary"  href="{{ url('/template_search')}}">查詢頁面<i class="fa fa-share" aria-hidden="true"></i></a>
                </div>
            </div>
        </div>
       
        <div class="row">
          <div class="input-group mb-3 mt-1" style="width: 500px;">
            <span class="input-group-text" id="inputGroup-sizing-default">樣板名稱</span>
            <input type="text" class="form-control" aria-label="Sizing example input" id="template_name" aria-describedby="inputGroup-sizing-default">
            <button class="btn btn-primary" onclick="btn_save()" type="button">儲存</button>
          </div>
          <div class="input-group mb-3 mt-1" style="width: 500px;">
            <span class="input-group-text" id="inputGroup-sizing-default">樣板類型</span>
            <select class="form-select" id="template_type" aria-label="Default select example">
                <option selected value="7">單周</option>
                <option value="14">雙周</option>
              </select>
          </div>
  
        </div>
        <div id="week_container"></div>
  </div>
    
@endsection
@section('scripts')
<script type="text/javascript">

  var final_solution=[];
        let result_json_array=[];
        function btn_save(){
          let template_type=parseInt($('#template_type').val());
          if($('#template_name').val()==''){
            Swal.fire({
                        icon: 'warning',
                        title: '糟糕...',
                        text: '請填入樣板名稱!'
                    });
            return ;
          }
    
          for(let i=1;i<=template_type;i++){
            let temp_array={};
            let temp_json={};
            temp_array.week_day=i;
 
            if($(`#full_time_doctor_morning_shift_human_resource_${i}`).val()!=""){
              temp_json.full_time_doctor_morning_shift=$(`#full_time_doctor_morning_shift_human_resource_${i}`).val();
            }else{
              temp_json.full_time_doctor_morning_shift=0;
            }
            if($(`#full_time_nurse_morning_shift_human_resource_${i}`).val()!=""){
              temp_json.full_time_nurse_morning_shift=$(`#full_time_nurse_morning_shift_human_resource_${i}`).val();
            }else{
              temp_json.full_time_nurse_morning_shift=0;
            }
            if($(`#full_time_pharmacist_morning_shift_human_resource_${i}`).val()!=""){
              temp_json.full_time_pharmacist_morning_shift=$(`#full_time_pharmacist_morning_shift_human_resource_${i}`).val();
            }else{
              temp_json.full_time_pharmacist_morning_shift=0;
            }
            if($(`#full_time_administration_staff_morning_shift_human_resource_${i}`).val()!=""){
              temp_json.full_time_administration_staff_morning_shift=$(`#full_time_administration_staff_morning_shift_human_resource_${i}`).val();
            }else{
              temp_json.full_time_administration_staff_morning_shift=0;
            }
            if($(`#part_time_worker_morning_shift_human_resource_${i}`).val()!=""){
              temp_json.part_time_worker_morning_shift=$(`#part_time_worker_morning_shift_human_resource_${i}`).val();
            }else{
              temp_json.part_time_worker_morning_shift=0;
            }

           
            if($(`#full_time_doctor_noon_shift_human_resource_${i}`).val()!=""){
              temp_json.full_time_doctor_noon_shift=$(`#full_time_doctor_noon_shift_human_resource_${i}`).val();
            }else{
              temp_json.full_time_doctor_noon_shift=0;
            }
            if($(`#full_time_nurse_noon_shift_human_resource_${i}`).val()!=""){
              temp_json.full_time_nurse_noon_shift=$(`#full_time_nurse_noon_shift_human_resource_${i}`).val();
            }else{
              temp_json.full_time_nurse_noon_shift=0;
            }
            if($(`#full_time_pharmacist_noon_shift_human_resource_${i}`).val()!=""){
              temp_json.full_time_pharmacist_noon_shift=$(`#full_time_pharmacist_noon_shift_human_resource_${i}`).val();
            }else{
              temp_json.full_time_pharmacist_noon_shift=0;
            }
            if($(`#full_time_administration_staff_noon_shift_human_resource_${i}`).val()!=""){
              temp_json.full_time_administration_staff_noon_shift=$(`#full_time_administration_staff_noon_shift_human_resource_${i}`).val();
            }else{
              temp_json.full_time_administration_staff_noon_shift=0;
            }
            if($(`#part_time_worker_noon_shift_human_resource_${i}`).val()!=""){
              temp_json.part_time_worker_noon_shift=$(`#part_time_worker_noon_shift_human_resource_${i}`).val();
            }else{
              temp_json.part_time_worker_noon_shift=0;
            }

          
            if($(`#full_time_doctor_night_shift_human_resource_${i}`).val()!=""){
              temp_json.full_time_doctor_night_shift=$(`#full_time_doctor_night_shift_human_resource_${i}`).val();
            }else{
              temp_json.full_time_doctor_night_shift=0;
            }
            if($(`#full_time_nurse_night_shift_human_resource_${i}`).val()!=""){
              temp_json.full_time_nurse_night_shift=$(`#full_time_nurse_night_shift_human_resource_${i}`).val();
            }else{
              temp_json.full_time_nurse_night_shift=0;
            }
            if($(`#full_time_pharmacist_night_shift_human_resource_${i}`).val()!=""){
              temp_json.full_time_pharmacist_night_shift=$(`#full_time_pharmacist_night_shift_human_resource_${i}`).val();
            }else{
              temp_json.full_time_pharmacist_night_shift=0;
            }
            if($(`#full_time_administration_staff_night_shift_human_resource_${i}`).val()!=""){
              temp_json.full_time_administration_staff_night_shift=$(`#full_time_administration_staff_night_shift_human_resource_${i}`).val();
            }else{
              temp_json.full_time_administration_staff_night_shift=0;
            }
            if($(`#part_time_worker_night_shift_human_resource_${i}`).val()!=""){
              temp_json.part_time_worker_night_shift=$(`#part_time_worker_night_shift_human_resource_${i}`).val();
            }else{
              temp_json.part_time_worker_night_shift=0;
            }
            temp_array.job_require=temp_json;
            result_json_array.push(temp_array);
          }


        //   
        $.ajax({
                type: 'POST',
                data:{
                    'template_name':$('#template_name').val(),
                    'template_type':$('#template_type').val(),
                    'template_json':JSON.stringify(result_json_array)
                },
                url: api_url + '/api/store_template',
                success: function(data) {
                    Swal.fire({
                        icon: 'success',
                        title: '新增成功',
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

        function load_template(){
            let template_type=parseInt($('#template_type').val());
            let week_day='';
            $('#week_container').empty();   
            for(let i=1;i<=template_type;i++){
              switch(i%7){
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
              // <input class="form-check-input me-1" id="full_time_doctor_morning_shift_${i}" type="checkbox" style="width: 30px;height:30px;" value="" aria-label="...">     
              $('#week_container').append(`
          
                    <div class="card mt-2">
                    <div class="card-horizontal">
                        <div class="card-header" >
                            <h4 class="align-self-center">${week_day}</h4> 
                        </div>
                        <div class="card-body">
                            <div class="row">
                              <div class="col-4">
                                <h5 class="text-center">早班</h5>
                                    <div class="input-group mb-2">
                                    
                                      <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">醫師</span>
                                      </div>
                                      <input type="number" class="form-control input-append" id="full_time_doctor_morning_shift_human_resource_${i}" placeholder="填入所需人力" min='1' value="">
                                    </div>
                                      <div class="input-group mb-2">
                                    
                                        <div class="input-group-prepend">
                                          <span class="input-group-text" id="basic-addon1">藥劑師</span>
                                        </div>
                                        <input type="number" class="form-control input-append" id="full_time_pharmacist_morning_shift_human_resource_${i}" placeholder="填入所需人力" min='1' value="">
                                      </div>
                                      <div class="input-group mb-2">
                                    
                                        <div class="input-group-prepend">
                                          <span class="input-group-text" id="basic-addon1">護士</span>
                                        </div>
                                        <input type="number" class="form-control input-append" id="full_time_nurse_morning_shift_human_resource_${i}" placeholder="填入所需人力" min='1' value="">
                                      </div>
                                      <div class="input-group mb-2">
                                    
                                        <div class="input-group-prepend">
                                          <span class="input-group-text" id="basic-addon1">行政人員</span>
                                        </div>
                                        <input type="number" class="form-control input-append" id="full_time_administration_staff_morning_shift_human_resource_${i}"  placeholder="填入所需人力" min='1' value="">
                                      </div>
                                      <div class="input-group mb-2">
                                    
                                        <div class="input-group-prepend">
                                          <span class="input-group-text" id="basic-addon1">工讀生</span>
                                        </div>
                                        <input type="number" class="form-control input-append" id="part_time_worker_morning_shift_human_resource_${i}" placeholder="填入所需人力" min='1' value="">
                                      </div>
                              </div>
                              <div class="col-4">
                                <h5 class="text-center">中班</h5>
                                    <div class="input-group mb-2">
                                    
                                      <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">醫師</span>
                                      </div>
                                      <input type="number" class="form-control input-append" id="full_time_doctor_noon_shift_human_resource_${i}" placeholder="填入所需人力" min='1' value="">
                                    </div>
                                      <div class="input-group mb-2">
                                    
                                        <div class="input-group-prepend">
                                          <span class="input-group-text" id="basic-addon1">藥劑師</span>
                                        </div>
                                        <input type="number" class="form-control input-append" id="full_time_pharmacist_noon_shift_human_resource_${i}" placeholder="填入所需人力" min='1' value="">
                                      </div>
                                      <div class="input-group mb-2">
                                    
                                        <div class="input-group-prepend">
                                          <span class="input-group-text" id="basic-addon1">護士</span>
                                        </div>
                                        <input type="number" class="form-control input-append" id="full_time_nurse_noon_shift_human_resource_${i}" placeholder="填入所需人力" min='1' value="">
                                      </div>
                                      <div class="input-group mb-2">
                                    
                                        <div class="input-group-prepend">
                                          <span class="input-group-text" id="basic-addon1">行政人員</span>
                                        </div>
                                        <input type="number" class="form-control input-append" id="full_time_administration_staff_noon_shift_human_resource_${i}"  placeholder="填入所需人力" min='1' value="">
                                      </div>
                                      <div class="input-group mb-2">
                                    
                                        <div class="input-group-prepend">
                                          <span class="input-group-text" id="basic-addon1">工讀生</span>
                                        </div>
                                        <input type="number" class="form-control input-append" id="part_time_worker_noon_shift_human_resource_${i}" placeholder="填入所需人力" min='1' value="">
                                      </div>
                              </div>
                              <div class="col-4">
                                <h5 class="text-center">晚班</h5>
                                    <div class="input-group mb-2">
                                    
                                      <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">醫師</span>
                                      </div>
                                      <input type="number" class="form-control input-append" id="full_time_doctor_night_shift_human_resource_${i}" placeholder="填入所需人力" min='1' value="">
                                    </div>
                                      <div class="input-group mb-2">
                                    
                                        <div class="input-group-prepend">
                                          <span class="input-group-text" id="basic-addon1">藥劑師</span>
                                        </div>
                                        <input type="number" class="form-control input-append" id="full_time_pharmacist_night_shift_human_resource_${i}" placeholder="填入所需人力" min='1' value="">
                                      </div>
                                      <div class="input-group mb-2">
                                    
                                        <div class="input-group-prepend">
                                          <span class="input-group-text" id="basic-addon1">護士</span>
                                        </div>
                                        <input type="number" class="form-control input-append" id="full_time_nurse_night_shift_human_resource_${i}" placeholder="填入所需人力" min='1' value="">
                                      </div>
                                      <div class="input-group mb-2">
                                    
                                        <div class="input-group-prepend">
                                          <span class="input-group-text" id="basic-addon1">行政人員</span>
                                        </div>
                                        <input type="number" class="form-control input-append" id="full_time_administration_staff_night_shift_human_resource_${i}"  placeholder="填入所需人力" min='1' value="">
                                      </div>
                                      <div class="input-group mb-2">
                                    
                                        <div class="input-group-prepend">
                                          <span class="input-group-text" id="basic-addon1">工讀生</span>
                                        </div>
                                        <input type="number" class="form-control input-append" id="part_time_worker_night_shift_human_resource_${i}" placeholder="填入所需人力" min='1' value="">
                                      </div>
                              </div>
                            </div>
                        </div>
                    </div>
                    </div>  
                    <br>
                
                    `);
                
                    }
            }
        $( document ).ready(function() {
            load_template();
            $('#template_type').on('change',function(){
                load_template();
            });


        });
</script>
@endsection

