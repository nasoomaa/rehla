{!! view_render_event('rehla.dashboard.catalog.product.edit.booking.appointment.before', ['product' => $product]) !!}

<!-- Vue Component -->
<v-appointment-booking :bookingProduct="$bookingProduct ?? []"></v-appointment-booking>

{!! view_render_event('rehla.dashboard.catalog.product.edit.booking.appointment.after', ['product' => $product]) !!}

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-appointment-booking-template"
    >
        <!-- Slot Duration -->
        <x-dashboard::form.control-group class="w-full">
            <x-dashboard::form.control-group.label class="required">
                @lang('dashboard::app.catalog.products.edit.types.booking.appointment.slot-duration')
            </x-dashboard::form.control-group.label>

            <x-dashboard::form.control-group.control
                type="text"
                name="booking[duration]"
                rules="required|min_value:1"
                v-model="appointment_booking.duration"
                :label="trans('dashboard::app.catalog.products.edit.types.booking.appointment.slot-duration')"
                :placeholder="trans('dashboard::app.catalog.products.edit.types.booking.appointment.slot-duration')"
            />

            <x-dashboard::form.control-group.error control-name="booking[duration]" />
        </x-dashboard::form.control-group>

        <!-- Break Time -->
        <x-dashboard::form.control-group class="w-full">
            <x-dashboard::form.control-group.label class="required">
                @lang('dashboard::app.catalog.products.edit.types.booking.appointment.break-duration')
            </x-dashboard::form.control-group.label>

            <x-dashboard::form.control-group.control
                type="text"
                name="booking[break_time]"
                rules="required|min_value:1"
                v-model="appointment_booking.break_time"
                :label="trans('dashboard::app.catalog.products.edit.types.booking.appointment.break-duration')"
                :placeholder="trans('dashboard::app.catalog.products.edit.types.booking.appointment.break-duration')"
            />

            <x-dashboard::form.control-group.error control-name="booking[break_time]" />
        </x-dashboard::form.control-group>

        <!-- Same slot for all days -->
        <x-dashboard::form.control-group class="w-full">
            <x-dashboard::form.control-group.label class="required">
                @lang('dashboard::app.catalog.products.edit.types.booking.appointment.same-slot-for-all-days.title')
            </x-dashboard::form.control-group.label>

            <x-dashboard::form.control-group.control
                type="select"
                name="booking[same_slot_all_days]"
                rules="required"
                v-model="appointment_booking.same_slot_all_days"
                :label="trans('dashboard::app.catalog.products.edit.types.booking.appointment.same-slot-for-all-days.title')"
                :placeholder="trans('dashboard::app.catalog.products.edit.types.booking.appointment.same-slot-for-all-days.title')"
            >
                <option value="1">
                    @lang('dashboard::app.catalog.products.edit.types.booking.appointment.same-slot-for-all-days.yes')
                </option>

                <option value="0">
                    @lang('dashboard::app.catalog.products.edit.types.booking.appointment.same-slot-for-all-days.no')
                </option>
            </x-dashboard::form.control-group.control>

            <x-dashboard::form.control-group.error control-name="booking[same_slot_all_days]" />
        </x-dashboard::form.control-group>

        <!-- Allow Slot Overlap -->
        <x-dashboard::form.control-group class="w-full">
            <x-dashboard::form.control-group.label>
                @lang('dashboard::app.catalog.products.edit.types.booking.allow-slot-overlap.title')
            </x-dashboard::form.control-group.label>

            <x-dashboard::form.control-group.control
                type="select"
                name="booking[allow_slot_overlap]"
                v-model="appointment_booking.allow_slot_overlap"
                :label="trans('dashboard::app.catalog.products.edit.types.booking.allow-slot-overlap.title')"
            >
                <option value="0">
                    @lang('dashboard::app.catalog.products.edit.types.booking.allow-slot-overlap.no')
                </option>

                <option value="1">
                    @lang('dashboard::app.catalog.products.edit.types.booking.allow-slot-overlap.yes')
                </option>
            </x-dashboard::form.control-group.control>
        </x-dashboard::form.control-group>

        <!-- Slots Vue Component -->
        <v-slots
            :booking-product="appointment_booking"
            :booking-type="'appointment_slot'"
            :same-slot-all-days="appointment_booking.same_slot_all_days"
            :allow-slot-overlap="appointment_booking.allow_slot_overlap"
            :min-slot-minutes="appointment_booking.duration"
        >
        </v-slots>
    </script>

    <script type="module">
        app.component('v-appointment-booking', {
            template: '#v-appointment-booking-template',

            props: ['bookingProduct'],

            data() {
                return {
                    appointment_booking: {!! json_encode($bookingProduct && $bookingProduct->appointment_slot
                        ? $bookingProduct->appointment_slot
                        : [
                            'duration' => 45,

                            'break_time' => 15,

                            'same_slot_all_days' => 1,

                            'allow_slot_overlap' => 0,

                            'slots' => [],
                        ]
                    ) !!}
                }
            },
        });
    </script>
@endpushOnce