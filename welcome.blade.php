<!DOCTYPE html>
<html>
    <head>
        <title>Laravel</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  
    </head>
    <body>
        <div class="container">
            <tasks></tasks>
        </div>
        
        
    <template id="tasks-template">
        
        <h1>My Tasks</h1>
        
        <ul class="list-group">
            
                
                <li class="list-group-item" v-for="task in list">
                    @{{ task.body }}
                    <button @click="delete(task)">X</button>
                </li>
                
            </ul>
    </template>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.11/vue.js"></script>
        
        <script>
        Vue.component('tasks', {
           template: '#tasks-template',
           
           data: function() {
               return {
                 list: []  
               };
           },
           
           created: function() {
               this.fetchTaskList();
           },
           
           methods: {
               delete: function(task){
                  this.list.$remove(task); 
               },
               
               fetchTaskList: function() {
                   $.getJSON('api/tasks', function(tasks) {
                  this.list = tasks;
                  }.bind(this));
              }
           }
           
        });
            
        new Vue({
           el: 'body' 
        });
        </script>
    </body>
</html>
