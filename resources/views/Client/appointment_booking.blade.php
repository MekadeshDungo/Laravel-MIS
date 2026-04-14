<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Appointment - Dasmariñas City Veterinary Services</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50 min-h-screen p-8">

<!-- Booking Component -->
<div x-data="bookingApp()" x-init="init()" class="max-w-4xl mx-auto">

    <!-- Header -->
    <div class="text-center mb-8">
        <h2 class="text-3xl font-bold text-gray-900">Book an Appointment</h2>
        <p class="text-gray-500 mt-2">Select a date and time for your visit</p>
    </div>

    <!-- Service Selection -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
        <h3 class="text-lg font-semibold mb-4">Select Service Type</h3>
        <div class="grid grid-cols-3 gap-4">
            <template x-for="service in services" :key="service.type">
                <button 
                    @click="selectService(service)"
                    :class="selectedService?.type === service.type ? 'border-primary bg-green-50' : 'border-gray-200 hover:border-primary-light'"
                    class="border-2 rounded-lg p-4 text-center transition-colors"
                >
                    <div class="font-semibold" x-text="service.label"></div>
                    <div class="text-sm text-gray-500" x-text="service.weight + ' units'"></div>
                </button>
            </template>
        </div>
    </div>

    <!-- Date Picker -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
        <h3 class="text-lg font-semibold mb-4">Select Date</h3>
        <input 
            type="date" 
            x-model="selectedDate"
            @change="loadSlots()"
            :min="minDate"
            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
        >
    </div>

    <!-- Time Slots Grid -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6" x-show="selectedDate">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold">Available Time Slots</h3>
            <div class="flex items-center gap-4 text-sm">
                <span class="flex items-center gap-1">
                    <span class="w-3 h-3 rounded-full bg-green-500"></span> Available
                </span>
                <span class="flex items-center gap-1">
                    <span class="w-3 h-3 rounded-full bg-yellow-500"></span> Limited
                </span>
                <span class="flex items-center gap-1">
                    <span class="w-3 h-3 rounded-full bg-red-500"></span> Full
                </span>
                <span class="flex items-center gap-1">
                    <span class="w-3 h-3 rounded-full bg-gray-300"></span> Blocked
                </span>
            </div>
        </div>

        <!-- Morning Section -->
        <div class="mb-6">
            <h4 class="text-sm font-medium text-gray-500 mb-3">Morning</h4>
            <div class="grid grid-cols-4 gap-3">
                <template x-for="slot in morningSlots" :key="slot.time">
                    <button 
                        @click="selectSlot(slot)"
                        :disabled="!slot.selectable"
                        :class="slot.cssClasses"
                        class="relative py-4 px-3 rounded-lg border-2 transition-all font-medium"
                    >
                        <span x-text="slot.display_time"></span>
                        
                        <!-- Status Badges -->
                        <span x-show="slot.status === 'available'" class="absolute -top-2 -right-2 w-5 h-5 bg-green-500 rounded-full flex items-center justify-center">
                            <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        </span>
                        <span x-show="slot.status === 'blocked'" class="absolute top-2 right-2">
                            <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                        </span>
                        
                        <!-- Capacity indicator -->
                        <div x-show="slot.remainingCapacity !== null && slot.remainingCapacity > 0" class="text-xs text-gray-500 mt-1">
                            <span x-text="slot.remainingCapacity"></span>/8 left
                        </div>
                    </button>
                </template>
            </div>
        </div>

        <!-- Afternoon Section -->
        <div>
            <h4 class="text-sm font-medium text-gray-500 mb-3">Afternoon</h4>
            <div class="grid grid-cols-4 gap-3">
                <template x-for="slot in afternoonSlots" :key="slot.time">
                    <button 
                        @click="selectSlot(slot)"
                        :disabled="!slot.selectable"
                        :class="slot.cssClasses"
                        class="relative py-4 px-3 rounded-lg border-2 transition-all font-medium"
                    >
                        <span x-text="slot.display_time"></span>
                        
                        <span x-show="slot.status === 'available'" class="absolute -top-2 -right-2 w-5 h-5 bg-green-500 rounded-full flex items-center justify-center">
                            <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        </span>
                        <span x-show="slot.status === 'blocked'" class="absolute top-2 right-2">
                            <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                        </span>
                        
                        <div x-show="slot.remainingCapacity !== null && slot.remainingCapacity > 0" class="text-xs text-gray-500 mt-1">
                            <span x-text="slot.remainingCapacity"></span>/8 left
                        </div>
                    </button>
                </template>
            </div>
        </div>
    </div>

    <!-- Real-time Availability Badge -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6" x-show="selectedSlot">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold">Selected Slot</h3>
                <p class="text-gray-500">
                    <span x-text="selectedSlotDisplay"></span> - 
                    <span :class="slotAvailable ? 'text-green-600' : 'text-red-600'" x-text="slotAvailable ? 'Slot Available' : 'Fully Booked'"></span>
                </p>
            </div>
            <div x-show="loading" class="animate-pulse">
                <span class="text-gray-500">Checking...</span>
            </div>
        </div>
    </div>

    <!-- Adoption Interview Options -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6" 
         x-show="selectedService?.type === 'adoption_interview'"
         x-transition>
        <h3 class="text-lg font-semibold mb-4">Interview Mode</h3>
        <div class="grid grid-cols-2 gap-4">
            <label class="flex items-center p-4 border-2 rounded-lg cursor-pointer"
                   :class="interviewMode === 'zoom' ? 'border-primary bg-green-50' : 'border-gray-200'">
                <input type="radio" name="interview_mode" value="zoom" x-model="interviewMode" class="mr-3">
                <div>
                    <div class="font-semibold">Zoom Meeting</div>
                    <div class="text-sm text-gray-500">Virtual video call</div>
                </div>
            </label>
            <label class="flex items-center p-4 border-2 rounded-lg cursor-pointer"
                   :class="interviewMode === 'in_person' ? 'border-primary bg-green-50' : 'border-gray-200'">
                <input type="radio" name="interview_mode" value="in_person" x-model="interviewMode" class="mr-3">
                <div>
                    <div class="font-semibold">In-Person</div>
                    <div class="text-sm text-gray-500">Visit the clinic</div>
                </div>
            </label>
        </div>
        
        <div x-show="interviewMode === 'zoom'" class="mt-4">
            <label class="block text-sm font-medium mb-2">Meeting Link (will be sent via email)</label>
            <input type="url" x-model="meetingLink" placeholder="https://zoom.us/j/..."
                   class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
        </div>
    </div>

    <!-- Submit Button -->
    <button 
        @click="submitAppointment()"
        :disabled="!canSubmit || submitting"
        class="w-full bg-primary text-white py-4 rounded-lg font-semibold hover:bg-primary-light transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
    >
        <span x-show="!submitting">Book Appointment</span>
        <span x-show="submitting" class="flex items-center justify-center gap-2">
            <svg class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Processing...
        </span>
    </button>

    <!-- Success Message -->
    <div x-show="successMessage" x-transition
         class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg flex items-center gap-3">
        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
        </svg>
        <span x-text="successMessage"></span>
    </div>

    <!-- Error Message -->
    <div x-show="errorMessage" x-transition
         class="fixed bottom-4 right-4 bg-red-500 text-white px-6 py-4 rounded-lg shadow-lg flex items-center gap-3">
        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
        </svg>
        <span x-text="errorMessage"></span>
    </div>

</div>

<script>
function bookingApp() {
    return {
        // Configuration
        dailyCapacity: 8,
        availableSlots: ['08:00', '09:00', '10:00', '11:00', '13:00', '14:00', '15:00'],
        blockedSlots: ['12:00', '16:00'],
        weights: { vaccination: 1, kapon: 2, adoption_interview: 1 },
        
        // State
        selectedService: null,
        selectedDate: '',
        selectedSlot: null,
        loading: false,
        submitting: false,
        slots: [],
        interviewMode: 'zoom',
        meetingLink: '',
        successMessage: '',
        errorMessage: '',
        
        services: [
            { type: 'vaccination', label: 'Vaccination', weight: 1 },
            { type: 'kapon', label: 'Kapon (Spay/Neuter)', weight: 2 },
            { type: 'adoption_interview', label: 'Adoption Interview', weight: 1 },
        ],
        
        get minDate() {
            const today = new Date();
            return today.toISOString().split('T')[0];
        },
        
        get morningSlots() {
            return this.slots.filter(s => parseInt(s.time) < 12).sort((a,b) => a.time.localeCompare(b.time));
        },
        
        get afternoonSlots() {
            return this.slots.filter(s => parseInt(s.time) >= 12).sort((a,b) => a.time.localeCompare(b.time));
        },
        
        get selectedSlotDisplay() {
            if (!this.selectedSlot) return '';
            return this.formatTime(this.selectedSlot.time);
        },
        
        get slotAvailable() {
            if (!this.selectedSlot) return false;
            return this.selectedSlot.status === 'available';
        },
        
        get canSubmit() {
            return this.selectedService && this.selectedDate && this.selectedSlot && this.slotAvailable;
        },
        
        init() {
            // Set default service
            this.selectedService = this.services[0];
        },
        
        selectService(service) {
            this.selectedService = service;
            if (this.selectedDate) this.loadSlots();
        },
        
        async loadSlots() {
            if (!this.selectedDate || !this.selectedService) return;
            
            this.loading = true;
            this.selectedSlot = null;
            
            try {
                const response = await fetch(`/api/appointments/slots?date=${this.selectedDate}`);
                const data = await response.json();
                
                if (data.success) {
                    this.slots = data.slots.map(slot => this.processSlot(slot));
                }
            } catch (error) {
                console.error('Failed to load slots:', error);
            } finally {
                this.loading = false;
            }
        },
        
        processSlot(slot) {
            const isBlocked = slot.is_blocked || slot.status === 'blocked';
            const isFull = slot.status === 'full';
            const isLimited = slot.status === 'limited';
            
            let cssClasses = 'border-gray-200 hover:border-primary text-gray-700';
            let selectable = false;
            
            if (isBlocked) {
                cssClasses = 'border-gray-200 bg-gray-100 text-gray-400 cursor-not-allowed';
                selectable = false;
            } else if (isFull) {
                cssClasses = 'border-red-200 bg-red-50 text-red-400 cursor-not-allowed';
                selectable = false;
            } else if (isLimited) {
                cssClasses = 'border-yellow-300 bg-yellow-50 hover:border-yellow-500 text-yellow-700';
                selectable = true;
            } else {
                cssClasses = 'border-green-300 bg-green-50 hover:border-green-500 text-green-700';
                selectable = true;
            }
            
            return {
                ...slot,
                cssClasses,
                selectable,
                isBlocked,
                isFull,
                isLimited
            };
        },
        
        selectSlot(slot) {
            if (!slot.selectable) return;
            
            this.selectedSlot = slot;
            this.checkSlotAvailability();
        },
        
        async checkSlotAvailability() {
            if (!this.selectedSlot) return;
            
            this.loading = true;
            
            try {
                const response = await fetch(
                    `/api/appointments/check?date=${this.selectedDate}&time=${this.selectedSlot.time}`
                );
                const data = await response.json();
                
                if (data.success && !data.available) {
                    this.selectedSlot = this.slots.find(s => s.time === this.selectedSlot.time);
                    this.errorMessage = 'This slot was just booked by another user';
                    setTimeout(() => this.errorMessage = '', 3000);
                }
            } catch (error) {
                console.error('Failed to check availability:', error);
            } finally {
                this.loading = false;
            }
        },
        
        async submitAppointment() {
            if (!this.canSubmit) return;
            
            this.submitting = true;
            this.successMessage = '';
            this.errorMessage = '';
            
            const payload = {
                appointment_date: this.selectedDate,
                appointment_time: this.selectedSlot.time,
                service_type: this.selectedService.type,
                service_id: this.getServiceId(),
                pet_ids: [this.getPetId()],
                meeting_link: this.interviewMode === 'zoom' ? this.meetingLink : null,
            };
            
            try {
                const response = await fetch('/api/appointments', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(payload)
                });
                
                const data = await response.json();
                
                if (data.success) {
                    this.successMessage = `Appointment booked for ${this.selectedDate} at ${this.formatTime(this.selectedSlot.time)}`;
                    this.selectedSlot = null;
                    this.loadSlots();
                    setTimeout(() => this.successMessage = '', 5000);
                } else {
                    this.errorMessage = data.message || 'Failed to book appointment';
                    setTimeout(() => this.errorMessage = '', 3000);
                }
            } catch (error) {
                this.errorMessage = 'An error occurred. Please try again.';
                setTimeout(() => this.errorMessage = '', 3000);
            } finally {
                this.submitting = false;
            }
        },
        
        formatTime(time) {
            const [hours, minutes] = time.split(':');
            const hour = parseInt(hours);
            const ampm = hour >= 12 ? 'PM' : 'AM';
            const hour12 = hour % 12 || 12;
            return `${hour12}:${minutes || '00'} ${ampm}`;
        },
        
        getServiceId() {
            return 1;
        },
        
        getPetId() {
            return 1;
        }
    };
}
</script>

</body>
</html>