<label for="imagens_respaldo" class="text-black-500 text-md p-2 {{$visible == false ? "hidden" :""}} ">{{$title}}
    <span class="text-red-500">{{$ob == true ? "*" : ""}} </span>
</label>

<div class="row" style="visibility: {{$visible == false ? "hidden" :""}}">
    <input type="file" name="imagens_respaldo1[]" id="imagens_respaldo"
           accept="docx,xlsx,xlx, base64"
           data-filenumber="{{$filenumber}}"
           class="file-input border-solid rounded-md border border-stone-200 bg-stone-200 h-18 w-full p-2 cursor-pointer
           {{$visible == false ? "hidden" :""}}">
    <button type="button" data-filenumber="{{$filenumber}}"
            class="{{$id}} ml-2 {{$visible == false ? "hidden" :""}} ">
        limpar
    </button>
</div>
