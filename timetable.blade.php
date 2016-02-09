@extends('layout')
@section('content')
<div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Timetable details</h1>
                    
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
                        
                        @if (isset($classes) and !empty($classes))
                            
                            @foreach($classes as $day => $lessons)
                            <div class="panel panel-default">
                            <div class="panel-heading">
                            {{{ date('l jS F Y', strtotime($day))  }}}
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <th>
                                        Time
                                    </th>
                                    <th>
                                        Subject
                                    </th>
                                    <th>
                                        Room
                                    </th>
                                    <th>
                                        Label
                                    </th>
                                    <th>
                                        Class
                                    </th>
                                    <th>
                                        Group
                                    </th>
                                @foreach ($lessons as $lesson)
                                <tr>
                                    <td>{{{ $lesson['timings'] }}}</td>
                                    <td>{{{ $lesson['description'] }}}</td>
                                    <td>{{{ $lesson['room'] }}}</td>
                                    <td>{{{ $lesson['label'] }}}</td>
                                    <td>{{{ $lesson['name'] }}}</td>
                                    <td><button @click="fetchGroup({{ $lesson['group'] }})">{{{ $lesson['group'] }}}</button></td>
                                    
                                </tr>
                                @endforeach
                                </table>
                                </div>
                            </div>
                            </div>
                            @endforeach
                            @else <h3>No scheduled classes yet</h3>
                        @endif
                       
                        <modal :show.sync="showModal" :group="group" :groupid="groupid"></modal>                
                        
                       
                         
<!-- template for the modal component -->
<script type="x/template" id="modal-template">
  <div class="modal-mask" v-show="show" transition="modal">
    <div class="modal-wrapper">
      <div class="modal-container">

        <div class="modal-header">
          <slot name="header">
            <h2>Group @{{ groupid }}</h2>
          </slot>
        </div>
        
        <div class="modal-body">
          <slot name="body">
                      
            <table class="table table-striped">
                <th>
                Name
                </th>
                <th>
                Course
                </th>
                <th>
                Age
                </th>
                <tr v-for="student in group">
                   <td>@{{ student.studentname }}</td>
                   <td>@{{ student.course }} </td>
                   <td>@{{ student.age }} </td>
                </tr>
            </table>
          </slot>
        </div>

        <div class="modal-footer">
         
            <button class="modal-default-button"
              @click="show = false">
              OK
            </button>
          
        </div>
      </div>
    </div>
  </div>
  </script>               
                        
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
@stop

@section('footer')
        
        
        
       <script> 
        
        new Vue({
            el: 'body',
            data: {
                group: [],
                show: false,
                showModal: false,
                groupid: ''
            },
            
            components: {
              modal: {
        template: '#modal-template',
        props: {
        show: {
        type: Boolean,
        required: true,
        twoWay: true    
        },
        group: {
            
        },
        groupid: {
            
        }
    } 
              }  
            },
            
            methods: {
               fetchGroup: function (groupid) {
                var resource = this.$resource('../api/timetable/:id');
                
                resource.get({id: groupid}, function(data){
                    this.group = data;
                    this.groupid = groupid;
                    this.show = true;
                    this.showModal = true;
                    
                })
               }
            }
            
        })
    </script>
@stop
