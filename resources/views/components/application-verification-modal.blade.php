{{-- resources/views/components/application-verification-modal.blade.php --}}
<div class="space-y-6 max-h-96 overflow-y-auto">
    
    {{-- Personal Information Section --}}
    <div class="bg-gray-50 rounded-lg p-4">
        <h3 class="text-lg font-semibold text-gray-900 mb-3 border-b border-gray-200 pb-2">
            Personal Information
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
            <div>
                <span class="font-medium text-gray-600">Full Name:</span>
                <span class="text-gray-900">{{ $application->fullname }}</span>
            </div>
            <div>
                <span class="font-medium text-gray-600">Email:</span>
                <span class="text-gray-900">{{ $application->user->email }}</span>
            </div>
            <div>
                <span class="font-medium text-gray-600">Date of Birth:</span>
                <span class="text-gray-900">{{ $application->dob }}</span>
            </div>
            <div>
                <span class="font-medium text-gray-600">Place of Birth:</span>
                <span class="text-gray-900">{{ $application->pob }}</span>
            </div>
            <div>
                <span class="font-medium text-gray-600">Gender:</span>
                <span class="text-gray-900">{{ ucfirst($application->gender) }}</span>
            </div>
            <div>
                <span class="font-medium text-gray-600">ID Number:</span>
                <span class="text-gray-900">{{ $application->idc_number }}</span>
            </div>
            <div>
                <span class="font-medium text-gray-600">Nationality:</span>
                <span class="text-gray-900">{{ $application->country }}</span>
            </div>
            <div>
                <span class="font-medium text-gray-600">Telephone:</span>
                <span class="text-gray-900">{{ $application->telephone }}</span>
            </div>
            <div class="md:col-span-2">
                <span class="font-medium text-gray-600">Address:</span>
                <span class="text-gray-900">{{ $application->address }}</span>
            </div>
            <div>
                <span class="font-medium text-gray-600">Marital Status:</span>
                <span class="text-gray-900">{{ ucfirst($application->marital_status) }}</span>
            </div>
            <div>
                <span class="font-medium text-gray-600">Bank Reference:</span>
                <span class="text-gray-900">{{ $application->bankref }}</span>
            </div>
        </div>
    </div>

    {{-- Location Information --}}
    <div class="bg-gray-50 rounded-lg p-4">
        <h3 class="text-lg font-semibold text-gray-900 mb-3 border-b border-gray-200 pb-2">
            Location Information
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
            <div>
                <span class="font-medium text-gray-600">Region:</span>
                <span class="text-gray-900">{{ $application->region->name ?? 'Not specified' }}</span>
            </div>
            <div>
                <span class="font-medium text-gray-600">Division:</span>
                <span class="text-gray-900">{{ $application->division->name ?? 'Not specified' }}</span>
            </div>
            <div>
                <span class="font-medium text-gray-600">Sub-Division:</span>
                <span class="text-gray-900">{{ $application->subDivision->name ?? 'Not specified' }}</span>
            </div>
        </div>
    </div>

    {{-- Guardian Information --}}
    <div class="bg-gray-50 rounded-lg p-4">
        <h3 class="text-lg font-semibold text-gray-900 mb-3 border-b border-gray-200 pb-2">
            Guardian Information
        </h3>
        
        {{-- Father Information --}}
        <div class="mb-4">
            <h4 class="font-medium text-gray-700 mb-2">Father</h4>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                <div>
                    <span class="font-medium text-gray-600">Name:</span>
                    <span class="text-gray-900">{{ $application->father_name }}</span>
                </div>
                <div>
                    <span class="font-medium text-gray-600">Contact:</span>
                    <span class="text-gray-900">{{ $application->father_contact ?? 'Not provided' }}</span>
                </div>
                <div>
                    <span class="font-medium text-gray-600">Address:</span>
                    <span class="text-gray-900">{{ $application->father_address ?? 'Not provided' }}</span>
                </div>
            </div>
        </div>

        {{-- Mother Information --}}
        <div class="mb-4">
            <h4 class="font-medium text-gray-700 mb-2">Mother</h4>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                <div>
                    <span class="font-medium text-gray-600">Name:</span>
                    <span class="text-gray-900">{{ $application->mother_name }}</span>
                </div>
                <div>
                    <span class="font-medium text-gray-600">Contact:</span>
                    <span class="text-gray-900">{{ $application->mother_contact ?? 'Not provided' }}</span>
                </div>
                <div>
                    <span class="font-medium text-gray-600">Address:</span>
                    <span class="text-gray-900">{{ $application->mother_address ?? 'Not provided' }}</span>
                </div>
            </div>
        </div>

        {{-- Guardian Information --}}
        <div>
            <h4 class="font-medium text-gray-700 mb-2">Guardian</h4>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                <div>
                    <span class="font-medium text-gray-600">Name:</span>
                    <span class="text-gray-900">{{ $application->guardian_name }}</span>
                </div>
                <div>
                    <span class="font-medium text-gray-600">Contact:</span>
                    <span class="text-gray-900">{{ $application->guardian_contact ?? 'Not provided' }}</span>
                </div>
                <div>
                    <span class="font-medium text-gray-600">Address:</span>
                    <span class="text-gray-900">{{ $application->guardian_address ?? 'Not provided' }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Academic Preferences --}}
    <div class="bg-gray-50 rounded-lg p-4">
        <h3 class="text-lg font-semibold text-gray-900 mb-3 border-b border-gray-200 pb-2">
            Academic Preferences
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
            <div>
                <span class="font-medium text-gray-600">Programme Option:</span>
                <span class="text-gray-900">
                    {{ \App\Models\DepartmentOption::where('id', $application->option)->first()->name ?? 'Not specified' }}
                </span>
            </div>
            <div>
                <span class="font-medium text-gray-600">Examination Center:</span>
                <span class="text-gray-900">{{ $application->examCenter->name ?? 'Not specified' }}</span>
            </div>
            <div>
                <span class="font-medium text-gray-600">Primary Language:</span>
                <span class="text-gray-900">{{ $application->primary_language == 'en' ? 'English' : 'French' }}</span>
            </div>
        </div>
        
        {{-- Math and English Requirements --}}
        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
            <div>
                <span class="font-medium text-gray-600">Has O/L Math:</span>
                <span class="text-gray-900 {{ $application->has_math == 'yes' ? 'text-green-600' : 'text-red-600' }}">
                    {{ ucfirst($application->has_math) }}
                </span>
            </div>
            <div>
                <span class="font-medium text-gray-600">Has O/L English:</span>
                <span class="text-gray-900 {{ $application->has_english == 'yes' ? 'text-green-600' : 'text-red-600' }}">
                    {{ ucfirst($application->has_english) }}
                </span>
            </div>
        </div>
    </div>

    {{-- Qualifications --}}
    @if($qualifications && $qualifications->count() > 0)
    <div class="bg-gray-50 rounded-lg p-4">
        <h3 class="text-lg font-semibold text-gray-900 mb-3 border-b border-gray-200 pb-2">
            Academic Qualifications
        </h3>
        <div class="space-y-3">
            @foreach($qualifications as $qualification)
            <div class="bg-white rounded border p-3">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 text-sm">
                    <div>
                        <span class="font-medium text-gray-600">Level:</span>
                        <span class="text-gray-900">{{ $qualification->qualificationType->name }}</span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-600">School:</span>
                        <span class="text-gray-900">{{ $qualification->school }}</span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-600">Year:</span>
                        <span class="text-gray-900">{{ $qualification->year }}</span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-600">Points:</span>
                        <span class="text-gray-900 font-semibold">{{ $qualification->points }}</span>
                    </div>
                </div>
                @if($qualification->certificate)
                <div class="mt-2 text-xs text-gray-500">
                    Certificate: ✓ Uploaded
                </div>
                @endif
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Application Number Preview --}}
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
        <h3 class="text-lg font-semibold text-blue-900 mb-2">
            Application Number (Preview)
        </h3>
        <p class="text-blue-800 font-mono text-lg">
            @php
                $prependedString = str_repeat('0', 4 - strlen(auth()->user()->id)) . auth()->user()->id;
            @endphp
            FHS{{ $application->option === 1 ? 'MLS' : 'NUS' }}24{{ $prependedString }}
        </p>
        <p class="text-sm text-blue-600 mt-1">
            Examination Date: <span class="font-semibold">14/09/2025</span>
        </p>
    </div>

    {{-- Confirmation Warning --}}
    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <svg class="w-5 h-5 text-yellow-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-yellow-800">
                    Important Notice
                </h3>
                <p class="mt-1 text-sm text-yellow-700">
                    Please review all information carefully. Once you confirm and submit your application, you will not be able to make any changes. Your application form will be automatically downloaded after confirmation.
                </p>
            </div>
        </div>
    </div>
</div>