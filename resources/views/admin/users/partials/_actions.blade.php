<div class="text-end">
    <a class="btn btn-sm" href="{{route('admin.users.edit', $id)}}">
        <i class="fa fa-edit"></i>
    </a>
    <form method="POST" action="{{route('admin.users.destroy', $id)}}" style="display: inline">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm">
            <i class="fa fa-trash"></i>
        </button>
    </form>
</div>
