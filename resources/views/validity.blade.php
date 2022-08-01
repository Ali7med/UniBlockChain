<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Finsh Stage') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                     </hr>
                    </br>
                    <h1>
                        @if ($result)
                        <i style="color:green;font-size:25px"
                        class="fa-solid fa-badge-check"></i>
                        Congratulation !!! Data valid Successfully
                        @else
                        <i style="color:red;font-size:25px"
                        class="fa-solid fa-badge-check"></i>
                        opps !!! Data not valid
                        @endif

                        <br/>
                    </h1>

                    <hr>

                 </div>
            </div>
        </div>
    </div>
</x-app-layout>
