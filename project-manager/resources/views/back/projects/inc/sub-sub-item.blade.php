<td>
    {{-- <a href="{{route('back.projects.sectionItemDelete', $sub_sub_item->id)}}" class="text-danger" onclick="return confirm('Are you sure to remove?');">
        <i class="fas fa-trash"></i>
    </a> --}}
    @include('back.projects.inc.edit-item-btn')

    {{$item->name}}
</td>
