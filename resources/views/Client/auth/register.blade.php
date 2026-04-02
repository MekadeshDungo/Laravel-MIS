<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Dasmariñas City Veterinary Services</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            DEFAULT: '#066D33',
                            light: '#077a40',
                            dark: '#055a29',
                        }
                    }
                }
            }
        }
    </script>
</head>

<body class="font-sans bg-gray-50 min-h-screen">

<!-- Header -->
<header class="bg-white border-b border-gray-200">
    <div class="max-w-6xl mx-auto px-6 py-4 flex items-center space-x-4">
        <img src="{{ asset('images/dasma logo.png') }}" class="w-12 h-12 object-contain" alt="Logo">
        <div>
            <h1 class="text-lg font-bold">Dasmariñas City Veterinary Services</h1>
            <p class="text-sm text-gray-600">Official Veterinary Office of Dasmariñas City</p>
        </div>
    </div>
</header>

<!-- Main -->
<main class="py-10">
    <div class="max-w-4xl mx-auto px-6">

        <!-- Title -->
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold">Sign Up</h2>
            <p class="mt-2 text-gray-600 text-sm">
                Fields marked with <span class="text-red-500">*</span> are required
            </p>
        </div>

        <!-- Session Status -->
        @if (session('status'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg text-sm">
                {{ session('status') }}
            </div>
        @endif

        <!-- Validation Errors -->
        @if ($errors->any())
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg text-sm">
                <strong>Please fix the following errors:</strong>
                <ul class="list-disc ml-5 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form Card -->
        <div class="bg-white border border-gray-200 rounded-lg p-8">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- PERSONAL INFO -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold mb-4 pb-2 border-b">Personal Information</h3>

                    <div class="grid md:grid-cols-4 gap-4">
                        <!-- Last Name -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5">
                                Last Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="last_name" value="{{ old('last_name') }}"
                                   class="w-full px-4 py-2.5 rounded-lg border border-gray-300
                                   focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none @error('last_name') border-red-500 @enderror">
                            @error('last_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- First Name -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5">
                                First Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="first_name" value="{{ old('first_name') }}"
                                   class="w-full px-4 py-2.5 rounded-lg border border-gray-300
                                   focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none @error('first_name') border-red-500 @enderror">
                            @error('first_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Middle Name -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5">
                                Middle Name
                            </label>
                            <input type="text" name="middle_name" value="{{ old('middle_name') }}"
                                   class="w-full px-4 py-2.5 rounded-lg border border-gray-300
                                   focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                        </div>

                        <!-- Suffix -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5">Suffix</label>
                            <input type="text" name="suffix" value="{{ old('suffix') }}" placeholder="Jr., Sr., III"
                                   class="w-full px-4 py-2.5 rounded-lg border border-gray-300
                                   focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                        </div>

                        <!-- Date of Birth -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium mb-1.5">
                                Date of Birth <span class="text-red-500">*</span>
                            </label>
                            <div class="grid grid-cols-3 gap-2">
                                <!-- Year -->
                                <select name="dob_year" class="w-full px-3 py-2.5 rounded-lg border border-gray-300
                                               focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none
                                               appearance-none bg-white @error('dob_year') border-red-500 @enderror"
                                        style="background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23066D33%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'); background-repeat: no-repeat; background-position: right 8px center; background-size: 10px 10px;">
                                    <option value="">Year</option>
                                    @for($year = date('Y'); $year >= 1900; $year--)
                                        <option value="{{ $year }}" {{ old('dob_year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                                    @endfor
                                </select>
                                <!-- Month -->
                                <select name="dob_month" class="w-full px-3 py-2.5 rounded-lg border border-gray-300
                                               focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none
                                               appearance-none bg-white @error('dob_month') border-red-500 @enderror"
                                        style="background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23066D33%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'); background-repeat: no-repeat; background-position: right 8px center; background-size: 10px 10px;">
                                    <option value="">Month</option>
                                    @for($month = 1; $month <= 12; $month++)
                                        <option value="{{ $month }}" {{ old('dob_month') == $month ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $month, 1)) }}</option>
                                    @endfor
                                </select>
                                <!-- Day -->
                                <select name="dob_day" class="w-full px-3 py-2.5 rounded-lg border border-gray-300
                                               focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none
                                               appearance-none bg-white @error('dob_day') border-red-500 @enderror"
                                        style="background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23066D33%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'); background-repeat: no-repeat; background-position: right 8px center; background-size: 10px 10px;">
                                    <option value="">Day</option>
                                    @for($day = 1; $day <= 31; $day++)
                                        <option value="{{ $day }}" {{ old('dob_day') == $day ? 'selected' : '' }}>{{ $day }}</option>
                                    @endfor
                                </select>
                            </div>
                            @error('dob_year')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            @error('dob_month')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            @error('dob_day')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Phone Number -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium mb-1.5">
                                Phone Number <span class="text-red-500">*</span>
                            </label>
                            <div class="flex">
                                <span class="inline-flex items-center px-4 py-2.5 rounded-l-lg border border-r-0 border-gray-300 bg-gray-100 text-gray-600 text-sm">
                                    +63
                                </span>
                                <input type="tel" name="phone_number" value="{{ old('phone_number') }}" placeholder="943 210 2012" maxlength="12"
                                       inputmode="numeric" pattern="[0-9\s]{12}"
                                       onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                       oninput="this.value = this.value.replace(/\D/g, '').replace(/(\d{3})(\d{3})(\d{4})/, '$1 $2 $3').trim()"
                                       class="flex-1 px-4 py-2.5 rounded-r-lg border border-gray-300
                                       focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none @error('phone_number') border-red-500 @enderror">
                            </div>
                            @error('phone_number')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email Address -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium mb-1.5">
                                Email Address <span class="text-red-500">*</span>
                            </label>
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="name@example.com"
                                   class="w-full px-4 py-2.5 rounded-lg border border-gray-300
                                   focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none @error('email') border-red-500 @enderror">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Block/Lot/Phase/House No. -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium mb-1.5">
                                Block/Lot/Phase/House No. <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="block_lot_phase_house_no" value="{{ old('block_lot_phase_house_no') }}"
                                   class="w-full px-4 py-2.5 rounded-lg border border-gray-300
                                   focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none @error('block_lot_phase_house_no') border-red-500 @enderror">
                            @error('block_lot_phase_house_no')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Street Name -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5">
                                Street Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="street_name" value="{{ old('street_name') }}"
                                   class="w-full px-4 py-2.5 rounded-lg border border-gray-300
                                   focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none @error('street_name') border-red-500 @enderror">
                            @error('street_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Subdivision -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5">
                                Subdivision <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="subdivision" value="{{ old('subdivision') }}"
                                   class="w-full px-4 py-2.5 rounded-lg border border-gray-300
                                   focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none @error('subdivision') border-red-500 @enderror">
                            @error('subdivision')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Barangay -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium mb-1.5">
                                Barangay <span class="text-red-500">*</span>
                            </label>
                            <select name="barangay" class="w-full px-4 py-2.5 pr-10 rounded-lg border border-gray-300
                                           focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none
                                           appearance-none bg-white @error('barangay') border-red-500 @enderror"
                                   style="background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23066D33%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'); background-repeat: no-repeat; background-position: right 12px center; background-size: 12px 12px;">
                                <option value="">Select Barangay</option>
                                <option value="Burol I" {{ old('barangay') == 'Burol I' ? 'selected' : '' }}>Burol I</option>
                                <option value="Burol II" {{ old('barangay') == 'Burol II' ? 'selected' : '' }}>Burol II</option>
                                <option value="Burol III" {{ old('barangay') == 'Burol III' ? 'selected' : '' }}>Burol III</option>
                                <option value="Burol Main" {{ old('barangay') == 'Burol Main' ? 'selected' : '' }}>Burol Main</option>
                                <option value="Datu Esmael (Bago-A-Ingud)" {{ old('barangay') == 'Datu Esmael (Bago-A-Ingud)' ? 'selected' : '' }}>Datu Esmael (Bago-A-Ingud)</option>
                                <option value="Emmanuel Bergaod I" {{ old('barangay') == 'Emmanuel Bergaod I' ? 'selected' : '' }}>Emmanuel Bergaod I</option>
                                <option value="Emmanuel Bergaod II" {{ old('barangay') == 'Emmanuel Bergaod II' ? 'selected' : '' }}>Emmanuel Bergaod II</option>
                                <option value="Fatima I" {{ old('barangay') == 'Fatima I' ? 'selected' : '' }}>Fatima I</option>
                                <option value="Fatima II" {{ old('barangay') == 'Fatima II' ? 'selected' : '' }}>Fatima II</option>
                                <option value="Fatima III" {{ old('barangay') == 'Fatima III' ? 'selected' : '' }}>Fatima III</option>
                                <option value="H-2 (Sta. Veronica)" {{ old('barangay') == 'H-2 (Sta. Veronica)' ? 'selected' : '' }}>H-2 (Sta. Veronica)</option>
                                <option value="Langkaan I (Humayao)" {{ old('barangay') == 'Langkaan I (Humayao)' ? 'selected' : '' }}>Langkaan I (Humayao)</option>
                                <option value="Langkaan II" {{ old('barangay') == 'Langkaan II' ? 'selected' : '' }}>Langkaan II</option>
                                <option value="Luzviminda I" {{ old('barangay') == 'Luzviminda I' ? 'selected' : '' }}>Luzviminda I</option>
                                <option value="Luzviminda II" {{ old('barangay') == 'Luzviminda II' ? 'selected' : '' }}>Luzviminda II</option>
                                <option value="Paliparan I" {{ old('barangay') == 'Paliparan I' ? 'selected' : '' }}>Paliparan I</option>
                                <option value="Paliparan II" {{ old('barangay') == 'Paliparan II' ? 'selected' : '' }}>Paliparan II</option>
                                <option value="Paliparan III" {{ old('barangay') == 'Paliparan III' ? 'selected' : '' }}>Paliparan III</option>
                                <option value="Sabang" {{ old('barangay') == 'Sabang' ? 'selected' : '' }}>Sabang</option>
                                <option value="Saint Peter I" {{ old('barangay') == 'Saint Peter I' ? 'selected' : '' }}>Saint Peter I</option>
                                <option value="Saint Peter II" {{ old('barangay') == 'Saint Peter II' ? 'selected' : '' }}>Saint Peter II</option>
                                <option value="Salawag" {{ old('barangay') == 'Salawag' ? 'selected' : '' }}>Salawag</option>
                                <option value="Salitran I" {{ old('barangay') == 'Salitran I' ? 'selected' : '' }}>Salitran I</option>
                                <option value="Salitran II" {{ old('barangay') == 'Salitran II' ? 'selected' : '' }}>Salitran II</option>
                                <option value="Salitran III" {{ old('barangay') == 'Salitran III' ? 'selected' : '' }}>Salitran III</option>
                                <option value="Salitran IV" {{ old('barangay') == 'Salitran IV' ? 'selected' : '' }}>Salitran IV</option>
                                <option value="Sampaloc I (Pala-Pala)" {{ old('barangay') == 'Sampaloc I (Pala-Pala)' ? 'selected' : '' }}>Sampaloc I (Pala-Pala)</option>
                                <option value="Sampaloc II (Bucal/Malinta)" {{ old('barangay') == 'Sampaloc II (Bucal/Malinta)' ? 'selected' : '' }}>Sampaloc II (Bucal/Malinta)</option>
                                <option value="Sampaloc III (Piela)" {{ old('barangay') == 'Sampaloc III (Piela)' ? 'selected' : '' }}>Sampaloc III (Piela)</option>
                                <option value="Sampaloc IV (Talisayan/Bautista)" {{ old('barangay') == 'Sampaloc IV (Talisayan/Bautista)' ? 'selected' : '' }}>Sampaloc IV (Talisayan/Bautista)</option>
                                <option value="Sampaloc V (New Era)" {{ old('barangay') == 'Sampaloc V (New Era)' ? 'selected' : '' }}>Sampaloc V (New Era)</option>
                                <option value="San Augustin I" {{ old('barangay') == 'San Augustin I' ? 'selected' : '' }}>San Augustin I</option>
                                <option value="San Augustin II (R. Tirona)" {{ old('barangay') == 'San Augustin II (R. Tirona)' ? 'selected' : '' }}>San Augustin II (R. Tirona)</option>
                                <option value="San Augustin III" {{ old('barangay') == 'San Augustin III' ? 'selected' : '' }}>San Augustin III</option>
                                <option value="San Andres I" {{ old('barangay') == 'San Andres I' ? 'selected' : '' }}>San Andres I</option>
                                <option value="San Andres II" {{ old('barangay') == 'San Andres II' ? 'selected' : '' }}>San Andres II</option>
                                <option value="San Antonio De Padua I" {{ old('barangay') == 'San Antonio De Padua I' ? 'selected' : '' }}>San Antonio De Padua I</option>
                                <option value="San Antonio De Padua II" {{ old('barangay') == 'San Antonio De Padua II' ? 'selected' : '' }}>San Antonio De Padua II</option>
                                <option value="San Dionisio" {{ old('barangay') == 'San Dionisio' ? 'selected' : '' }}>San Dionisio</option>
                                <option value="San Esteban" {{ old('barangay') == 'San Esteban' ? 'selected' : '' }}>San Esteban</option>
                                <option value="San Fransisco I" {{ old('barangay') == 'San Fransisco I' ? 'selected' : '' }}>San Fransisco I</option>
                                <option value="San Fransisco II" {{ old('barangay') == 'San Fransisco II' ? 'selected' : '' }}>San Fransisco II</option>
                                <option value="San Isidro Labrador I" {{ old('barangay') == 'San Isidro Labrador I' ? 'selected' : '' }}>San Isidro Labrador I</option>
                                <option value="San Isidro Labrador II" {{ old('barangay') == 'San Isidro Labrador II' ? 'selected' : '' }}>San Isidro Labrador II</option>
                                <option value="San Jose" {{ old('barangay') == 'San Jose' ? 'selected' : '' }}>San Jose</option>
                                <option value="San Juan" {{ old('barangay') == 'San Juan' ? 'selected' : '' }}>San Juan</option>
                                <option value="San Lorenzo Ruiz I" {{ old('barangay') == 'San Lorenzo Ruiz I' ? 'selected' : '' }}>San Lorenzo Ruiz I</option>
                                <option value="San Lorenzo Ruiz II" {{ old('barangay') == 'San Lorenzo Ruiz II' ? 'selected' : '' }}>San Lorenzo Ruiz II</option>
                                <option value="San Luis I" {{ old('barangay') == 'San Luis I' ? 'selected' : '' }}>San Luis I</option>
                                <option value="San Luis II" {{ old('barangay') == 'San Luis II' ? 'selected' : '' }}>San Luis II</option>
                                <option value="San Manuel I" {{ old('barangay') == 'San Manuel I' ? 'selected' : '' }}>San Manuel I</option>
                                <option value="San Manuel II" {{ old('barangay') == 'San Manuel II' ? 'selected' : '' }}>San Manuel II</option>
                                <option value="San Mateo" {{ old('barangay') == 'San Mateo' ? 'selected' : '' }}>San Mateo</option>
                                <option value="San Miguel I" {{ old('barangay') == 'San Miguel I' ? 'selected' : '' }}>San Miguel I</option>
                                <option value="San Miguel II" {{ old('barangay') == 'San Miguel II' ? 'selected' : '' }}>San Miguel II</option>
                                <option value="San Nicolas I" {{ old('barangay') == 'San Nicolas I' ? 'selected' : '' }}>San Nicolas I</option>
                                <option value="San Nicolas II" {{ old('barangay') == 'San Nicolas II' ? 'selected' : '' }}>San Nicolas II</option>
                                <option value="San Roque" {{ old('barangay') == 'San Roque' ? 'selected' : '' }}>San Roque</option>
                                <option value="San Simon" {{ old('barangay') == 'San Simon' ? 'selected' : '' }}>San Simon</option>
                                <option value="Santa Cristina I" {{ old('barangay') == 'Santa Cristina I' ? 'selected' : '' }}>Santa Cristina I</option>
                                <option value="Santa Cristina II" {{ old('barangay') == 'Santa Cristina II' ? 'selected' : '' }}>Santa Cristina II</option>
                                <option value="Santa Cruz I" {{ old('barangay') == 'Santa Cruz I' ? 'selected' : '' }}>Santa Cruz I</option>
                                <option value="Santa Cruz II" {{ old('barangay') == 'Santa Cruz II' ? 'selected' : '' }}>Santa Cruz II</option>
                                <option value="Santa Fe" {{ old('barangay') == 'Santa Fe' ? 'selected' : '' }}>Santa Fe</option>
                                <option value="Santa Lucia" {{ old('barangay') == 'Santa Lucia' ? 'selected' : '' }}>Santa Lucia</option>
                                <option value="Santa Maria" {{ old('barangay') == 'Santa Maria' ? 'selected' : '' }}>Santa Maria</option>
                                <option value="Santo Cristo" {{ old('barangay') == 'Santo Cristo' ? 'selected' : '' }}>Santo Cristo</option>
                                <option value="Santo Niño I" {{ old('barangay') == 'Santo Niño I' ? 'selected' : '' }}>Santo Niño I</option>
                                <option value="Santo Niño II" {{ old('barangay') == 'Santo Niño II' ? 'selected' : '' }}>Santo Niño II</option>
                                <option value="Victoria Reyes" {{ old('barangay') == 'Victoria Reyes' ? 'selected' : '' }}>Victoria Reyes</option>
                                <option value="Zone I" {{ old('barangay') == 'Zone I' ? 'selected' : '' }}>Zone I</option>
                                <option value="Zone I-A" {{ old('barangay') == 'Zone I-A' ? 'selected' : '' }}>Zone I-A</option>
                                <option value="Zone II" {{ old('barangay') == 'Zone II' ? 'selected' : '' }}>Zone II</option>
                                <option value="Zone III" {{ old('barangay') == 'Zone III' ? 'selected' : '' }}>Zone III</option>
                                <option value="Zone IV" {{ old('barangay') == 'Zone IV' ? 'selected' : '' }}>Zone IV</option>
                            </select>
                            @error('barangay')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- City -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5">City</label>
                            <input value="Dasmariñas City" disabled
                                   class="w-full px-4 py-2.5 rounded-lg border bg-gray-50 text-gray-500">
                        </div>

                        <!-- Province -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5">Province</label>
                            <input value="Cavite" disabled
                                   class="w-full px-4 py-2.5 rounded-lg border bg-gray-50 text-gray-500">
                        </div>
                    </div>
                </div>

                <!-- ACCOUNT SECURITY -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold mb-4 pb-2 border-b">Account Security</h3>

                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium mb-1.5">
                                Password <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="password" id="password" name="password"
                                       class="w-full px-4 py-2.5 pr-10 rounded-lg border border-gray-300
                                       focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none @error('password') border-red-500 @enderror"
                                       oninput="updatePasswordStrength()">
                                <button type="button" onclick="togglePassword('password')"
                                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                    <svg class="w-5 h-5" id="password-eye" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </button>
                            </div>
                            <!-- Password Strength Meter -->
                            <div class="mt-2">
                                <div class="flex items-center gap-1 mb-1">
                                    <div id="strength-bar-1" class="h-1 flex-1 rounded-full bg-gray-200 transition-colors"></div>
                                    <div id="strength-bar-2" class="h-1 flex-1 rounded-full bg-gray-200 transition-colors"></div>
                                    <div id="strength-bar-3" class="h-1 flex-1 rounded-full bg-gray-200 transition-colors"></div>
                                    <div id="strength-bar-4" class="h-1 flex-1 rounded-full bg-gray-200 transition-colors"></div>
                                </div>
                                <p id="strength-text" class="text-xs text-gray-500">Enter a password</p>
                            </div>
                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1.5">
                                Confirm Password <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                       class="w-full px-4 py-2.5 pr-10 rounded-lg border border-gray-300
                                       focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                                <button type="button" onclick="togglePassword('password_confirmation')"
                                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                    <svg class="w-5 h-5" id="password_confirmation-eye" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TERMS -->
                <div class="mb-6">
                    <label class="inline-flex items-start text-sm text-gray-600">
                        <input type="checkbox" name="terms" class="mt-1 mr-2" {{ old('terms') ? 'checked' : '' }}>
                        I agree to the <span class="text-primary ml-1">Terms and Conditions</span>
                    </label>
                    @error('terms')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- SUBMIT -->
                <button type="submit"
                        class="w-full bg-primary text-white py-3 rounded-lg font-semibold hover:bg-primary-light">
                    Sign Up
                </button>
            </form>
        </div>

        <!-- Footer Links -->
        <div class="text-center mt-6 text-sm">
            Already have an account?
            <a href="{{ route('login') }}" class="text-primary font-medium">Login here</a>
        </div>
    </div>
</main>

    <script>
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const eyeIcon = document.getElementById(fieldId + '-eye');
            
            if (field.type === 'password') {
                field.type = 'text';
                eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>';
            } else {
                field.type = 'password';
                eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>';
            }
        }

        function updatePasswordStrength() {
            const password = document.getElementById('password').value;
            const bars = [
                document.getElementById('strength-bar-1'),
                document.getElementById('strength-bar-2'),
                document.getElementById('strength-bar-3'),
                document.getElementById('strength-bar-4')
            ];
            const strengthText = document.getElementById('strength-text');

            // Reset bars
            bars.forEach(bar => bar.className = 'h-1 flex-1 rounded-full bg-gray-200 transition-colors');

            if (password.length === 0) {
                strengthText.textContent = 'Enter a password';
                strengthText.className = 'text-xs text-gray-500';
                return;
            }

            let score = 0;

            // Check length (minimum 8 characters)
            if (password.length >= 8) score++;
            // Check for lowercase
            if (/[a-z]/.test(password)) score++;
            // Check for uppercase
            if (/[A-Z]/.test(password)) score++;
            // Check for numbers
            if (/[0-9]/.test(password)) score++;
            // Check for special characters
            if (/[^a-zA-Z0-9]/.test(password)) score++;

            // Cap score at 4 for the 4-bar display
            const displayScore = Math.min(score, 4);

            // Colors for different strength levels
            const colors = {
                0: 'bg-red-500',      // Very Weak
                1: 'bg-red-400',      // Weak
                2: 'bg-yellow-400',   // Fair
                3: 'bg-green-400',    // Good
                4: 'bg-green-600'     // Strong
            };

            const texts = {
                0: 'Very weak - add more characters',
                1: 'Weak - add uppercase, numbers, or symbols',
                2: 'Fair - could be stronger',
                3: 'Good - secure enough',
                4: 'Strong - excellent password!'
            };

            // Update bars
            for (let i = 0; i < displayScore; i++) {
                bars[i].className = `h-1 flex-1 rounded-full ${colors[displayScore]} transition-colors`;
            }

            // Update text
            strengthText.textContent = texts[displayScore];
            
            // Set text color based on strength
            if (displayScore <= 1) {
                strengthText.className = 'text-xs text-red-500';
            } else if (displayScore === 2) {
                strengthText.className = 'text-xs text-yellow-600';
            } else {
                strengthText.className = 'text-xs text-green-600';
            }
        }
    </script>
</body>
</html>
