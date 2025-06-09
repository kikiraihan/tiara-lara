<x-slot name="stylehalaman">
    @livewireStyles
    <style>
        pre {
            white-space: pre-wrap; /* Since CSS 2.1 */
            white-space: -moz-pre-wrap; /* Mozilla, since 1999 */
            white-space: -pre-wrap; /* Opera 4-6 */
            white-space: -o-pre-wrap; /* Opera 7 */
            word-wrap: break-word; /* Internet Explorer 5.5+ */
        }
    </style>
</x-slot>

<x-slot name="scripthalaman">
    @livewireScripts    
    @script
    <script>
        $wire.on('infer-success', (e) => {
            try{
                cl(e)
                // alert("infer-completed evt");
                cl("infer-success evt")
                cl(arguments)
            
                /*
                wip
                - after infer
                    - show brief data from ajax
                        - col description
                        - brief y result
                    - show 
                */
            }catch(e){

            }
        })

        $wire.on('infer-fail', (e) => {
            alert(JSON.stringify( e))
        })

        window.addEventListener('infer-completed', event => {
            console.log("wael infer-completed");
            console.log(event)
            console.log(event.data)
            // alert('Name updated to: ' + event.detail.newName);
        })
    </script>
    @endscript

</x-slot>

<div class="w-full h-full">
    
    {{-- <div class="text-lg mb-3">
        Group
    </div> --}}

    <div>
        {{ $this->table }}
    </div>
</div>