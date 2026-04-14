<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

@props([
    'serviceType' => 'vaccination',
    'minDate' => '',
    'fieldName' => 'appointment_date'
])

<div x-data="appointmentSlotPicker()" class="space-y-4">
    <!-- Date Picker -->
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">
            Select Appointment Date <span class="text-red-500">*</span>
        </label>
        <input 
            type="date" 
            x-model="selectedDate"
            @change="loadSlots()"
            @input="selectedTime = ''"
            :min="minDateValue"
            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
        >
    </div>

    <!-- Real-time Slots Available Badge -->
    <div x-show="selectedDate && !loading" class="flex items-center gap-2 text-sm">
        <span class="inline-flex items-center px-3 py-1 rounded-full"
              :class="dailyRemainingBadgeClass">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <span x-text="dailyCapacityText"></span>
        </span>
    </div>

    <!-- Loading State -->
    <div x-show="loading" class="flex items-center justify-center py-4">
        <svg class="animate-spin h-6 w-6 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        <span class="ml-2 text-gray-500">Checking availability...</span>
    </div>

    <!-- Time Slots Grid -->
    <div x-show="selectedDate && !loading && slots.length > 0" class="mt-4">
        <label class="block text-sm font-medium text-gray-700 mb-3">
            Select Time <span class="text-red-500">*</span>
        </label>
        
        <!-- Legend -->
        <div class="flex flex-wrap gap-3 mb-4 text-xs">
            <span class="flex items-center gap-1">
                <span class="w-3 h-3 rounded-full bg-green-400"></span> Available
            </span>
            <span class="flex items-center gap-1">
                <span class="w-3 h-3 rounded-full bg-yellow-400"></span> Limited
            </span>
            <span class="flex items-center gap-1">
                <span class="w-3 h-3 rounded-full bg-red-300"></span> Full
            </span>
            <span class="flex items-center gap-1">
                <span class="w-3 h-3 rounded-full bg-gray-300"></span> Not Available
            </span>
        </div>

        <!-- 3-Column Grid -->
        <div class="grid grid-cols-3 gap-3">
            <template x-for="slot in sortedSlots" :key="slot.time">
                <button 
                    type="button"
                    @click="selectSlot(slot)"
                    :disabled="isSlotDisabled(slot)"
                    class="relative py-4 px-3 rounded-lg border-2 transition-all font-medium text-sm"
                    :class="getSlotClasses(slot)"
                >
                    <span x-text="slot.display_time"></span>
                    
                    <!-- Checkmark for selected -->
                    <span x-show="selectedTime === slot.time" class="absolute -top-2 -right-2 w-5 h-5 bg-primary rounded-full flex items-center justify-center">
                        <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                    </span>
                    
                    <!-- Blocked Labels -->
                    <div x-show="slot.time === '12:00'" class="text-xs mt-1 opacity-75">
                        Lunch
                    </div>
                    <div x-show="slot.time === '16:00'" class="text-xs mt-1 opacity-75">
                        Paperwork
                    </div>
                    
                    <!-- Slot Status Text -->
                    <template x-if="slot.status === 'blocked'">
                        <div class="text-xs mt-1 opacity-75">Not Available</div>
                    </template>
                    <template x-if="slot.status === 'full'">
                        <div class="text-xs mt-1 opacity-75">Fully Booked</div>
                    </template>
                    <template x-if="slot.status === 'limited'">
                        <div class="text-xs mt-1 opacity-75">1 slot left</div>
                    </template>
                    <template x-if="slot.status === 'available'">
                        <div class="text-xs mt-1 opacity-75">2 slots left</div>
                    </template>
                    <template x-if="slot.is_past">
                        <div class="text-xs mt-1 opacity-75">Past</div>
                    </template>
                </button>
            </template>
        </div>
    </div>

    <!-- No Date Selected -->
    <div x-show="selectedDate && !loading && slots.length === 0" class="text-center py-8 text-gray-500">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 mx-auto mb-2 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
        </svg>
        <p>Select a date to view available time slots</p>
    </div>

    <!-- Hidden Inputs for Form Submission -->
    <input type="hidden" name="{{ $fieldName }}_date" :value="selectedDate">
    <input type="hidden" name="{{ $fieldName }}_time" :value="selectedTime">
    <input type="hidden" name="service_type" value="{{ $serviceType }}">
</div>

<script>
function appointmentSlotPicker() {
    return {
        selectedDate: '',
        selectedTime: '',
        slots: [],
        loading: false,
        serviceType: '{{ $serviceType }}',
        dailyWeightUsed: 0,
        dailyRemaining: 12,
        dailyCapacity: 12,
        hourlyCapacity: 2,
        currentHour: new Date().getHours(),
        currentMinute: new Date().getMinutes(),
        
        // Use prop or default to today
        minDate: '',

        get today() {
            return new Date().toISOString().split('T')[0];
        },

        get minDateValue() {
            return this.minDate || this.today;
        },

        get sortedSlots() {
            return [...this.slots].sort((a, b) => a.time.localeCompare(b.time));
        },

        get isToday() {
            return this.selectedDate === this.today;
        },

        get isDailyFull() {
            return this.dailyRemaining <= 0;
        },

        get dailyCapacityText() {
            if (!this.selectedDate) return '';
            if (this.isDailyFull) return 'Fully Booked';
            if (this.dailyRemaining >= 2) return `${this.dailyRemaining} slots available`;
            if (this.dailyRemaining === 1) return `1 slot available`;
            return 'Fully Booked';
        },

        get dailyRemainingBadgeClass() {
            if (!this.selectedDate) return '';
            if (this.isDailyFull) return 'bg-red-100 text-red-700';
            if (this.dailyRemaining >= 2) return 'bg-green-100 text-green-700';
            return 'bg-yellow-100 text-yellow-700';
        },

        async loadSlots() {
            if (!this.selectedDate) return;
            
            this.loading = true;
            this.selectedTime = '';
            
            // Update current time
            const now = new Date();
            this.currentHour = now.getHours();
            this.currentMinute = now.getMinutes();
            
            try {
                const response = await fetch(`/api/appointments/slots?date=${this.selectedDate}`);
                const data = await response.json();
                
                if (data.success) {
                    this.slots = data.slots;
                    this.dailyWeightUsed = data.daily_weight_used || 0;
                    this.dailyRemaining = data.daily_remaining || 0;
                    this.dailyCapacity = data.capacity_limit || 12;
                    this.hourlyCapacity = data.hourly_capacity || 2;
                }
            } catch (error) {
                console.error('Failed to load slots:', error);
            } finally {
                this.loading = false;
            }
        },

        isSlotPast(slot) {
            if (!this.isToday) return false;
            
            const [slotHour, slotMinute] = slot.time.split(':').map(Number);
            const currentTimeInMinutes = this.currentHour * 60 + this.currentMinute;
            const slotTimeInMinutes = slotHour * 60 + slotMinute;
            
            return slotTimeInMinutes <= currentTimeInMinutes;
        },

        isSlotDisabled(slot) {
            return slot.status === 'blocked' || 
                   slot.status === 'full' || 
                   this.isSlotPast(slot) ||
                   slot.is_past;
        },

        selectSlot(slot) {
            if (this.isSlotDisabled(slot)) return;
            this.selectedTime = slot.time;
        },

        getSlotClasses(slot) {
            const isPast = this.isSlotPast(slot);
            
            if (slot.status === 'blocked') {
                if (slot.time === '12:00') {
                    return 'bg-gray-100 border-gray-200 text-gray-400 cursor-not-allowed';
                }
                if (slot.time === '16:00') {
                    return 'bg-gray-100 border-gray-200 text-gray-400 cursor-not-allowed';
                }
                return 'bg-gray-100 border-gray-200 text-gray-400 cursor-not-allowed';
            }
            
            if (slot.status === 'full') {
                return 'bg-red-50 border-red-200 text-red-400 cursor-not-allowed';
            }
            
            if (isPast) {
                return 'bg-gray-50 border-gray-200 text-gray-300 cursor-not-allowed';
            }
            
            if (this.selectedTime === slot.time) {
                if (slot.status === 'limited') {
                    return 'bg-yellow-500 border-yellow-500 text-white';
                }
                return 'bg-primary border-primary text-white';
            }
            
            if (slot.status === 'limited') {
                return 'bg-yellow-50 border-yellow-300 text-yellow-700 hover:border-yellow-500 hover:bg-yellow-100';
            }
            
            return 'bg-green-50 border-green-300 text-green-700 hover:border-green-500 hover:bg-green-100';
        }
    }
}
</script>