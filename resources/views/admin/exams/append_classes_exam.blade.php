<select class="form-control append_classes_exam" name="class_id[]" required multiple="multiple" width="100%">
    @if (!empty($getclasses))
        @foreach ($getclasses as $class)
            <option value="{{ $class['id'] }}">{{ $class['name'] }}</option>
        @endforeach
    @endif
    {{-- {{$view}} --}}
</select>

@push('script')
    <script>
        $(".append_classes_exam").select2({

            multiple: true,

        })

    </script>
@endpush
