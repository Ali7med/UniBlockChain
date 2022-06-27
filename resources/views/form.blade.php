<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200" style="font-weight: bold;">
                    <div>
                        <img src="{{asset('assets/logo.png')}}"  alt="" style="float: right;width: 82px;">
                    </div>
                    The main form for entering the final exam grades for student  of the first stage - Department of Computer Science
                    <hr/><br>
                    <div>
                        <x-label for="name" value="Student Name" />
                         <select name="name" id="" class="block mt-1 w-full">
                         @foreach ($students as $std )
                            <option value="{{ $std->id }}">{{ $std->name }}</option>
                         @endforeach
                        </select>
                    </div>
                    <div>
                        <x-label for="email" value="Computer Organization" />
                        <x-input id="email" class="block mt-1 w-full" type="text" name="email"
                         :value="old('email')" required autofocus />
                    </div>
                    <div>
                        <x-label for="email" value="Structured Programming" />
                        <x-input id="email" class="block mt-1 w-full" type="text" name="email"
                         :value="old('email')" required autofocus />
                    </div>
                    <div>
                        <x-label for="email" value="Mathematics" />
                        <x-input id="email" class="block mt-1 w-full" type="text" name="email"
                         :value="old('email')" required autofocus />
                    </div>
                    <div>
                        <x-label for="email" value="Discrete Structure" />
                        <x-input id="email" class="block mt-1 w-full" type="text" name="email"
                         :value="old('email')" required autofocus />
                    </div>
                    <div>
                        <x-label for="email" value="Logic Design" />
                        <x-input id="email" class="block mt-1 w-full" type="text" name="email"
                         :value="old('email')" required autofocus />
                    </div>
                    <div>
                        <x-label for="email" value="Human Rights" />
                        <x-input id="email" class="block mt-1 w-full" type="text" name="email"
                         :value="old('email')" required autofocus />
                    </div>
                    <div>
                        <x-label for="email" value="Arabic Language" />
                        <x-input id="email" class="block mt-1 w-full" type="text" name="email"
                         :value="old('email')" required autofocus />
                    </div>
                    <div class="flex items-center justify-end mt-4">


                        <x-button class="ml-3">
                          cancel
                        </x-button>
                        <x-button class="ml-3">
                            save
                          </x-button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
