<div class="card">
  <div class="card-header">Users</div>
    <div class="card-body">
      @if ($users->isEmpty())
        <p>No users</p>
      @else
        <ul class="list-group list-group-flush">
          
          @foreach ($users as $user)
            @php
              $id1 = auth()->user()->id;
              $id2 = $user->id;
              if($id1 < $id2){
                $ids = $id1. '-' .$id2;
              }else{
                $ids = $id2. '-' .$id1;
              }
            @endphp
            <a href="{{ route('messages.chat', [ 'ids' => $ids ]) }}" class="list-group-item list-group-item-action">{{ $user->name }}</a>
          @endforeach
        </ul>
      @endif
  </div>
</div>