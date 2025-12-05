@extends('layouts.home_layout')
@section('title', "Placed Order")
@section('style')
    @vite(['resources/css/menu/placed-order.css'])
@endsection
@section('content')
<div id="order-container">
    <center><h4 id="your-header">YOUR</h4></center>
    <center><h2 id="order-header">ORDER NUMBER</h2></center>
    <center><h1 id="order-number">{{ $payment['id'] }}</h1></center>

    {{-- START: NEW STATUS DISPLAY BLOCK --}}
    <div class="status-display" style="text-align: center; margin: 20px 0; padding: 15px; border-radius: 10px; background-color: #f9f9f9;">
        @if($payment['remarks'] == 'Ongoing')
            <h2 style="color: #666; font-weight: 800; margin: 0;">⏳ ORDER PLACED</h2>
            <p style="margin: 5px 0 0 0;">Waiting for kitchen confirmation...</p>
        
        @elseif($payment['remarks'] == 'Preparing')
            <h2 style="color: #e67e22; font-weight: 800; margin: 0;">🔥 PREPARING</h2>
            <p style="margin: 5px 0 0 0;">Our chefs are cooking your meal!</p>
            
        @elseif($payment['remarks'] == 'Ready for Pickup')
            <h2 style="color: #27ae60; font-weight: 800; margin: 0;">✅ READY FOR PICKUP</h2>
            <p style="margin: 5px 0 0 0;">Please proceed to the counter.</p>
        @endif
    </div>
    {{-- END: NEW STATUS DISPLAY BLOCK --}}

    <center><h2 id="branchH">{{ $branch['branch_name'] }}</h2></center>
    <center><h4 id="addH">{{ $branch['barangay'] }}, {{ $branch['city'] }}</h4></center>

    <center><button onclick="window.location.href = '{{ route('order.map') }}'" id="veiwMap">VIEW MAP</button></center>

    <center><h3 id="phoneH"><strong>PHONE NUMBER</strong></h3></center>
    <center><h4 id="phone-number">{{ $branch['phone_num'] }}</h4></center>

    <center><h3 id="order-summary-header">ORDERS:</h3></center>
    <center><button onclick="window.location.href = '{{ route('order.list') }}'" id="summaryOrders">CHECK ORDERS</button></center>

    <br>
    <br>

    <div id="PC-complete">
        <center class="place-order-buttons">
            {{-- Logic: Only show cancel options if the order is NOT cooking yet --}}
            @if($payment['remarks'] == 'Ongoing' || $payment['remarks'] == 'Preparing')
                @if ($cancellable)
                    <button class="cancel-btn" value="{{ route('order.cancel') }}">CANCEL</button>
                @else
                    <button class="uncancellable">CANCEL</button>
                @endif
            @endif
            
            {{-- Optional: Show a "Finish" button if ready, or just let them pick it up --}}
            @if($payment['remarks'] == 'Ready for Pickup')
                {{-- FIXED: Use a Form to trigger the update function, not a simple redirect --}}
                <form action="{{ route('order.received', $payment['id']) }}" method="POST" style="width: 100%">
                    @csrf
                    <button type="submit" class="recievedOrderButton">
                        👍 I RECEIVED MY ORDER
                    </button>
                </form>
            @endif
        </center>
    </div>
    <div id="MB-complete">
        <center class="place-order-buttons">
            @if($payment['remarks'] == 'Ongoing')
                @if ($cancellable)
                    <button class="cancel-btn" value="{{ route('order.cancel') }}">CANCEL</button>
                @else
                    <button class="uncancellable">CANCEL</button>
                @endif
            @endif

            @if($payment['remarks'] == 'Ready for Pickup')
    <form action="{{ route('order.received', $payment['id']) }}" method="POST">
        @csrf
        <button type="submit" style="background-color: #27ae60; color: white; padding: 15px 30px; border: none; border-radius: 5px; font-weight: bold; cursor: pointer; font-size: 16px;">
            👍 I RECEIVED MY ORDER
        </button>
    </form>
@endif
        </center>
    </div>
</div>

<div id="cancelModal" class="modal-bg" style="display:none;">
    <div class="modal-box">
        <h2>Cancel Order</h2>
        <p>Please provide a reason for cancelling your order:</p>

        <form id="cancelForm" method="POST" action="{{ route('order.cancel') }}">
            @csrf
            <textarea name="reason" id="cancelReason" placeholder="Type your reason..." required></textarea>

            <div class="modal-actions">
                <button type="button" id="cancelClose">Close</button>
                <button type="submit" id="cancelSubmit">Submit</button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('script')
    @vite(['resources/js/placed-order.js'])
    
    <script>
        // AUTO-REFRESH SCRIPT
        // Checks for updates every 10 seconds so the customer sees when status changes
    </script>
@endsection