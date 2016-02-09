@extends('layout')
@section('content')
<div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Students in school</h1>
                    
                    <div class="panel panel-default">
                    <div class="panel-heading">
                            Select week
                        </div>
                            <div class="panel-body">
                    {{ Form::open() }}
                    
                    <div class='col-lg-4'>
                        
                        <div class="form-group">
                            {{ Form::select('weeks', $weeks, $default, ['class' => 'form-control']) }}
                        </div>
                    
                     {{ Form::submit('Submit', ['class' => "btn btn-default"]) }} <br/><br/>
                {{ Form::close() }}
                        
                    </div>
                    
                    
                    <!-- /.col-lg-12 -->
                            </div>
                    </div>
                        
                        @if (isset($students) and !empty($students))
                            
                           
                        <h3>{{ count($students) }} students in school this week</h3>
                        
                                <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <th>
                                        Booking
                                    </th>
                                    <th>
                                        Name
                                    </th>
                                    <th>
                                        Course
                                    </th>
                                    <th>
                                        Dates
                                    </th>
                                    <th>
                                        Account
                                    </th>
                                @foreach ($students as $student)
                                @if ($student->age > 0 && $student->age < 18)
                                <tr class="warning">
                                @else
                                <tr>
                                @endif
                                    <td>{{{ $student->bookno }}}</td>
                                    <td>{{{ $student->studentname }}}</td>
                                    <td>{{{ $student->course }}}</td>
                                    <td>{{{ $student->coursedates }}}</td>
                                    
                                    @if ($student->userid)
                                    <td><a class="visible-link" href="{{ action('TeacherController@studentProfile', $student->userid) }}">Yes</a>
                                        <br /><button @click="showForm({{ $student->userid }}, '{{ preg_replace('/[,]/', '', $student->studentname) }}')">Add result</button></td>
                                    @else <td>No</td>
                                    @endif
                                    
                                </tr>
                                @endforeach
                                </table>
                                </div>
                            
                            @else <h3>No Students in school</h3>
                        @endif
                        
                        
                        
                        
                        
                        
                        <modal :show.sync="showModal" :student="student" :name="name"></modal>
                        
                        </div>
                
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
@stop

@section('footer')
<!-- template for the modal component -->
<template id="modal-template">
  <div class="modal-mask" v-show="show" transition="modal">
    <div class="modal-wrapper">
      <div class="modal-container">

        <div class="modal-header">
          
            <h2>Add a monthly result for @{{ name }}</h2>
          
        </div>
        
        <div class="modal-body">
          
            
            <form @submit.prevent="onSubmit" method="post">
                        
                        <input name="_token" type="hidden" value="{{ csrf_token() }}">
                        
                        <div class="form-group">
                            <label for="test_date">Test date:</label>
                            <input required="required" class="form-control datepicker" name="test_date" type="text" id="test_date" v-model="newResult.test_date">
                        </div>
                                
                        <div class="form-group">
                            <label for="speaking">Speaking (out of 15):</label>
                            <input required="required" class="form-control" name="speaking" type="text" id="speaking" v-model="newResult.speaking">
                        </div>
                                
                        <div class="form-group">
                            <label for="writing">Writing (out of 15):</label>
                            <input required="required" class="form-control" name="writing" type="text" id="writing" v-model="newResult.writing">
                        </div>
                                
                        <div class="form-group">
                            <label for="use">Use of English (out of 50):</label>
                            <input required="required" class="form-control" name="use" type="text" id="use" v-model="newResult.use">
                        </div>    
                                
                        <input class="btn btn-default" type="submit" value="Submit">
                        
                        
           </form>

            
          
        </div>

        <div class="modal-footer">
         
            <button class="modal-default-button"
              @click="show = false">
              Cancel
            </button>
          
        </div>
      </div>
    </div>
  </div>
</template>
<script>
    Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('input[name="_token"]').value;
    
    new Vue({
       el: 'body',
       
       components: {
           modal: {
               template: '#modal-template',
               
               props: {
        show: {
        type: Boolean,
        required: true,
        twoWay: true    
        },
        student: {
            
        },
        
        name: {
            
        },
        
        newResult: {
            _token: '',
            use: '',
            writing: '',
            speaking: '',
            test_date: ''
        }
    },
    
    methods: {
       onSubmit: function(e) {
               e.preventDefault();
               
               var result = this.newResult;
               
               this.$http.post('../api/monthly/' + this.student, result, function(data){
                 this.newResult = { _token: '', use: '', writing: '', speaking: '', test_date: '' }
                 
                 if (data.ok) {
                     swal("Success", "Monthly result successfully added", "success");
                 } else {
                     swal("Error", "Could not add monthly result", "error");
                 }
               });
               
               this.show = false;
           },
    }
           }
       },
       
       data: {
          student: '',
          showModal: false,
          show: false,
          name: '',
          newResult: {
            _token: '',
            use: '',
            writing: '',
            speaking: '',
            
        }
          
       },
       
       methods: {
           showForm: function(student, name) {
               this.student = student;
               this.showModal = true;
               this.show = true;
               this.name = name;
           }
           
        },
        
        events: {
           
       }
       
       // display modal form
       
       // post data via ajax
       
       // check response and show an appropriate sweet alert
    });
    
</script>

@stop