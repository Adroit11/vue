@extends('layout')
@section('content')
<div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Profile for {{ $student->username }}</h1>
                    
                        @if (Session::has('flash_notification.message'))
                        <div class="alert alert-{{ Session::get('flash_notification.level') }}">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

                        {{ Session::get('flash_notification.message') }}
                        </div>
                        @endif
                        
                        @if ($errors->any())
                        <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{{ $error }}}</li>
                            @endforeach
                        </ul>
                        </div>
                        @endif
                        
                        
                    @if (isset($tuitionNotes) and !empty($tuitionNotes))
                    <div class="panel panel-default">
                    <div class="panel-heading">
                            Tuition notes
                        </div>
                            <div class="panel-body">
                                <ul>
                                    @if (!empty($tuitionNotes->tnote1))
                                    <li>{{{ $tuitionNotes->tnote1 }}}</li>
                                    @endif
                                    @if (!empty($tuitionNotes->tnote2))
                                    <li>{{{ $tuitionNotes->tnote2 }}}</li>
                                    @endif
                                    @if (!empty($tuitionNotes->tnote3))
                                    <li>{{{ $tuitionNotes->tnote3 }}}</li>
                                    @endif
                                    @if (!empty($tuitionNotes->tnote4))
                                    <li>{{{ $tuitionNotes->tnote4 }}}</li>
                                    @endif
                                </ul>
                    </div>
                    </div>
                    @endif
                    
                    @if (isset($attendance) and !empty($attendance))
                    <div class="panel panel-default">
                    <div class="panel-heading">
                            Attendance
                        </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <th>
                                        Week commencing
                                    </th>
                                    <th>
                                        Scheduled hours
                                    </th>
                                    <th>
                                        Attended hours
                                    </th>
                                    <th>
                                        Missed hours
                                    </th>
                                    <th>
                                        Percent attendance
                                    </th>
                                @foreach ($attendance as $attended)
                                @if ($attended['Section'] == '20')
                                <tr>
                                    <td>{{{ trim($attended['Monday7']) }}}</td> 
                                    <td>{{{ $attended['ScheduledHours'] }}}</td> 
                                    <td>{{{ $attended['AttendedHours'] }}}</td>
                                    <td>{{{ $attended['TruantHours'] }}}</td> 
                                    <td>{{{ $attended['PCent'] }}}%</td> 
                                </tr>
                                @endif
                                @if ($attended['Section'] == '30')
                                <td><b>Total</b></td> 
                                <td><b>{{{ $attended['ScheduledHours'] }}}</b></td> 
                                <td><b>{{{ $attended['AttendedHours'] }}}</b></td>
                                <td><b>{{{ $attended['TruantHours'] }}}</b></td> 
                                <td><b>{{{ $attended['PCent'] }}}%</b></td>
                                @endif
                                @endforeach
                                </table>
                                </div>
                        
                        
                    </div>
                    </div>
                    @endif
                    
                    
                    <div class="panel panel-default">
                    <div class="panel-heading">
                            Videos
                        </div>
                    <div class="panel-body">
                        
                        <h3>Upload a video</h3>
                        
                   {{ Form::open(['files' => true, 'url' => 'teacher/students/video']) }}
                        
                        <div class="form-group">
                            {{ Form::label('description', 'Description:') }}
                            {{ Form::text('description', null, ['required', 'maxlength' => 255, 'class' => 'form-control']) }}
                            
                        </div>
                        
                        <div class="form-group">
                            {{ Form::file('video', ['required', 'class' => 'form-control']) }}
                        </div>
                    
                        {{ Form::hidden('studentid', $student->id) }}
                        
                     {{ Form::submit('Submit', ['class' => "btn btn-default"]) }} <br/><br/>    
                     {{ Form::close() }}
                     <h3>Existing videos</h3>
                     @if (count($videos))
                     <ul>
                         @foreach ($videos as $video)
                         <li>{{{ date('l jS F Y', strtotime($video['created_at'])) }}}: {{{$video['displayname']   }}}</li>
                         @endforeach
                     </ul>
                     @endif
                     
                    </div>
                    </div>
                     
                    
                     <div class="panel panel-default">
                    <div class="panel-heading">
                            Goals
                        </div>
                    <div class="panel-body">   
                        @if (count($goals))
                        <ul>
                            @foreach ($goals as $goal)
                            <li><a href="{{ action('TeacherController@viewGoal', $goal->id) }}" class="visible-link">{{{ $goal->name }}}: {{{ $goal->text }}}</a>
                            @if ($goal->teacher_complete)
                            (COMPLETE)
                            @else 
                            (OPEN)
                            @endif
                            </li>
                            @endforeach
                        </ul>
                        @endif
                        
                        <h3>Create a goal</h3>
                        
                        {{ Form::open(['url' => 'teacher/students/goals/addgoal']) }}
                    
                    
                        
                        <div class="form-group">
                            {{ Form::label('goal', 'Goal:') }}
                            {{ Form::textarea('goal', null, ['required', 'maxlength' => 255, 'class' => 'form-control']) }}
                        </div>
                        
                    <div class="form-group">
                        {{ Form::label('goal_type', 'Goal type:') }}
                        {{ Form::select('goal_type', $goal_types, null, ['class' => 'form-control']) }} 
                    </div>
                    
                    <div class="form-group">
                        {{ Form::label('complete_by', 'To be completed by:') }}
                        {{ Form::text('complete_by', null, ['class' => 'form-control datepicker']) }}
                    </div>
                     {{ Form::hidden('userid', $student->id) }}
                    
                     {{ Form::submit('Submit', ['class' => "btn btn-default"]) }} <br/><br/>
                     
                {{ Form::close() }}
                    </div>
                     </div>
                    
                           
                           
                     <div class="panel panel-default">
                    <div class="panel-heading">
                            CEFR level
                        </div>
                    <div class="panel-body">       
                        {{ Form::open() }}
                        <div class="form-group">
                            {{ Form::label('level', 'CEFR level:') }}
                            {{ Form::select('level', $levels, $current_level, ['class' => 'form-control']) }}
                        </div>
                        
                        {{ Form::submit('Submit', ['class' => 'btn btn-default']) }}
                        {{ Form::close() }}
                    </div>
                     </div>
                     
                    <div class="panel panel-default">
                    <div class="panel-heading">
                            Assessment
                        </div>
                    <div class="panel-body">       
                        @if (isset($quizzes) and !empty($quizzes))
                                <ul>
                                    @foreach ($quizzes as $quiz)
                                    <li><a href="{{ URL::to('teacher/assessment/view/' . $student->id . '/' . $quiz->quiz_id) }}" class="visible-link">{{{ $quiz->title }}}</a> - Score: {{{ $quiz->achieved }}}/{{{ $quiz->max }}}</li>
                                    @endforeach
                                </ul>
                                @else
                                <p>No quizzes available right now.</p>
                                @endif 
                    </div>
                     </div>
                    
                    <div class="panel panel-default">
                    <div class="panel-heading">
                            Monthly results
                        </div>
                    <div class="panel-body">       
                        @if (count($student->monthly))
                        
                        <a href="{{ URL::to('teacher/students/monthly/' . $student->id)  }}" class="visible-link">Detailed breakdown</a>
                        <p>Use of English totals:</p>
                                <ul>
                                    @foreach ($student->monthly as $monthly)
                                    <li>{{ date('M Y', strtotime($monthly->test_date)) }}: {{ $monthly->use  }}/50 <button @click="showForm({{ $monthly->id }})">Edit/Delete</button></li>
                                    @endforeach
                                </ul>
                                @else
                                <p>No monthly results yet.</p>
                                @endif 
                                
                                <h4>Add new monthly result</h4>
                                {{ Form::open(['url' => 'teacher/students/addresult/' . $student->id]) }}
                        
                        <div class="form-group">
                            {{ Form::label('test_date', 'Test date:') }}
                            {{ Form::text('test_date', null, ['required', 'class' => 'form-control datepicker']) }}
                        </div>
                                
                        <div class="form-group">
                            {{ Form::label('speaking', 'Speaking (out of 15):') }}
                            {{ Form::text('speaking', null, ['required', 'class' => 'form-control']) }}
                        </div>
                                
                        <div class="form-group">
                            {{ Form::label('writing', 'Writing (out of 15):') }}
                            {{ Form::text('writing', null, ['required', 'class' => 'form-control']) }}
                        </div>
                                
                        <div class="form-group">
                            {{ Form::label('use', 'Use of English (out of 50):') }}
                            {{ Form::text('use', null, ['required', 'class' => 'form-control']) }}
                        </div>    
                                
                        {{ Form::submit('Submit', ['class' => 'btn btn-default']) }}
                        {{ Form::close() }}
                    </div>
                     </div>
                    
                    <modal :show.sync="showModal" :key="key" :use="use" :speaking="speaking" :writing="writing" :test_date="test_date"></modal>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
@stop
@section('footer')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<template id="modal-template">
  <div class="modal-mask" v-show="show" transition="modal">
    <div class="modal-wrapper">
      <div class="modal-container">

        <div class="modal-header">
          
            <h2>Edit or delete a monthly result</h2>
          
        </div>
        
        <div class="modal-body">
          
            
            <form @submit.prevent="onSubmit" method="post" id="monthlyForm">
                        
                        <input name="_token" type="hidden" value="{{ csrf_token() }}">
                        <input name="_method" type="hidden" value="PATCH">
                        
                        
                        <div class="form-group">
                            <label for="test_date">Test date:</label>
                            <input required="required" class="form-control" name="test_date" type="text" id="test_date2" v-dates="test_date">
                        </div>
                                
                        <div class="form-group">
                            <label for="speaking">Speaking (out of 15):</label>
                            <input required="required" class="form-control" name="speaking" type="number" id="speaking" v-model="speaking">
                        </div>
                                
                        <div class="form-group">
                            <label for="writing">Writing (out of 15):</label>
                            <input required="required" class="form-control" name="writing" type="number" id="writing" v-model="writing">
                        </div>
                                
                        <div class="form-group">
                            <label for="use">Use of English (out of 50):</label>
                            <input required="required" class="form-control" name="use" type="number" id="use" v-model="use">
                        </div>    
                                
                        <input class="btn btn-default" type="submit" value="Submit">
                        <button type="button" @click="onDelete" class="btn btn-default">Delete</button>
                        
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
    
 var vm = new Vue({
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
        key: {
            
        },
        
        name: {
            
        },
        
        
            _token: '',
            use: '',
            writing: '',
            speaking: '',
            test_date: ''
        
    },
    
    directives: {
        dates: {
           bind: function () {
    var vm = this.vm;
    var key = this.expression;
    $(this.el).datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd-mm-yy',
        yearRange: 'c-115:c+15',
        
      onSelect: function (date) {
        vm.$set(key, date);
      }
    });
  },
  update: function (val) {
    
    $(this.el).datepicker('setDate', val);
  } 
        }
    },
    
    methods: {
       onSubmit: function(e) {
               e.preventDefault();
               
               var formData = {
                   use: this.use,
                   speaking: this.speaking,
                   writing: this.writing,
                   test_date: this.test_date
               };
               
               this.$http.patch('../../api/monthly/' + this.key, formData, function(data){
                 
                 if (data.ok) {
                     swal("Success", "Monthly result successfully updated", "success");
                     location.reload();
                 } else {
                     swal("Error", "Could not update monthly result. Please check your inputs.", "error");
                 }
               });
               
               this.show = false;
               
               
           },
           
           onDelete: function(e) {
               e.preventDefault();
               
               swal({
                title: "Are you sure?",
                text: "You will not be able to recover this result!",   
                type: "warning",   
                showCancelButton: true,   
                confirmButtonColor: "#DD6B55",   
                confirmButtonText: "Yes, delete it!",   
                closeOnConfirm: false 
                }, 
                function(){
                
                vm.$http.delete('../../api/monthly/' + vm.key, function(data){
                    
                   if (data.ok) {
                   swal("Deleted!", "Monthly result deleted successfully.", "success");
                   location.reload();
                    } else {
                       swal("Error", "Could not delete monthly result.", "error"); 
                    }
                });
                });
                this.show = false;
           }
           
    }
           }
       },
       
       data: {
          key: '',
          showModal: false,
          show: false,
          name: '',
          use: '',
          writing: '',
          speaking: '',
          test_date: ''
        
       },
       
       methods: {
           showForm: function(key) {
               
               this.$http.get('../../api/monthly/' + key, function(result){
                  console.log(result);
                  
                  this.key = key;
                  this.use = result.use;
                  this.writing = result.writing;
                  this.speaking = result.speaking;
                  
                  var changedDate = moment(result.test_date, 'YYYY-MM-DD');
                  
                  this.test_date = changedDate.format('DD-MM-YYYY');
                  
               });
               
               this.showModal = true;
               this.show = true;
           }
        },
        events: {
           
       }
    });
    </script>
@stop