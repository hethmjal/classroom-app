import './bootstrap';

/* import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
 */

if(classroomId ?? false){
    Echo.private('classroom.' + classroomId)
    .listen('.classwork-created',function (data) {
        alert(data.title);
    })
    
}

Echo.private('App.Models.User.' + userId)
.notification(function(event){
    alert(event.body)
})