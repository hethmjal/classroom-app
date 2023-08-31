

<div class="row">
   
    <div class="col-md-8"> 
     
       
      <div class="form-floating mb-3">
          <input type="text" value="{{old('title',$classwork->title)}}" class="form-control 
           @error('title') is-invalid @enderror"
           name="title" id="title" placeholder="Title">
          <label for="title">Title</label>
        </div>
      
        <div class="form-group mb-3">
          <label for="description">Description</label>

          <textarea class="form-control @error('section') is-invalid @enderror"
           name="description" id="description" placeholder="Description" cols="50" rows="30">{{old('description',$classwork->description)}}</textarea>
        </div>

       
       
      

        
</div>
    <div class="col-md-4">
        <div class="form-floating mb-3">
            <input type="date" value="{{old('published_at',$classwork->publish_date )}}" class="form-control 
            @error('published_at') is-invalid @enderror"
            name="published_at" id="published_at" placeholder="published at">
           <label for="published_at">Publish date</label>
            </div>

      <h4>Students</h4>
     
        @foreach ($classroom->students as $student)
        <div class="form-check mb-3">
            @php
                $test = 1;
                if (count($assigned) == 0) {
                    $test = 0;
                }
            @endphp
          <input class="form-check-input"   @if((!count($assigned) > 0 && $test == 1) ||  in_array($student->id,$assigned)) checked @endif  @if($label == 'Create') checked @endif   name="students[]" type="checkbox" value="{{$student->id}}" id="{{$student->id}}">
          <label class="form-check-label" for="{{$student->id}}">
            {{$student->name}}
          </label>
        </div>
     
        @endforeach
     
      
        @if($type == 'assignment')
        <div class="form-floating mb-3">
          <input type="number" value="{{old('options.grade',$classwork->options['grade'] ?? '')}}" class="form-control 
          @error('options.grade') is-invalid @enderror"
          name="options[grade]" id="grade" placeholder="Grade">
         <label for="grade">Grade</label>
          </div>
  
          <div class="form-floating mb-3">
              <input type="date" value="{{old('options.due',$classwork->options['due']?? '' )}}" class="form-control 
              @error('options.due') is-invalid @enderror"
              name="options[due]" id="due" placeholder="Due">
             <label for="due">Due</label>
              </div>
        @endif

        <div class="col-md mb-3">
            <div class="form-floating">
              <select name="topic_id" class="form-select" id="floatingSelectGrid" aria-label="Floating label select example">
                <option selected>select topic</option>
                @foreach ($classroom->topics as $topic)
                <option @selected($topic->id == $classwork->topic_id) value="{{$topic->id}}">{{$topic->name}}</option>
                @endforeach
              </select>
              <label for="floatingSelectGrid">Topics</label>
            </div>
          </div>
    </div>
    <div class="form-floating mb-3">
    <button type="submit" class="btn btn-primary">{{$label}}</button>
    </div>
  </div>
  @push('js')
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.tiny.cloud/1/ulvovj9koej4u574v16izj81utmzeuh2clmge12b2gkzntyb/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script> 
   <script>
   tinymce.init({
      selector: '#description',
      plugins: 'ai tinycomments mentions anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount checklist mediaembed casechange export formatpainter pageembed permanentpen footnotes advtemplate advtable advcode editimage tableofcontents mergetags powerpaste tinymcespellchecker autocorrect a11ychecker typography inlinecss',
      toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | align lineheight | tinycomments | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
      tinycomments_mode: 'embedded',
      tinycomments_author: 'Author name',
      mergetags_list: [
        { value: 'First.Name', title: 'First Name' },
        { value: 'Email', title: 'Email' },
      ],
      ai_request: (request, respondWith) => respondWith.string(() => Promise.reject("See docs to implement AI Assistant"))
    });

  </script>
  @endpush