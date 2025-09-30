     <section>
            <div class="emi-section" id="emiSection">
                <div class="container">

                    <div class="main-heading extra-margin-top">
                        <h2><span>EMI</span> Calculator</h2>
                    </div>

                    <div class="emiSecDiv">

                        <div class="loan-calculator">
                            <div class="top">
                                <!-- <h2></h2> -->

                                <form action="#">
                                    <div class="group">
                                        <div class="title">Loan Amount (<span>₹</span>)</div>
                                        <input type="number" value="100000" class="loan-amount" required />
                                    </div>

                                    <div class="group">
                                        <div class="title">Interest Rate (%)</div>
                                        <input type="number" value="4.5" class="interest-rate" required />
                                    </div>

                                    <div class="group">
                                        <div class="title">Tenure (in months)</div>
                                        <input type="number" value="24" class="loan-tenure" required />
                                    </div>
                                </form>
                            </div>

                            <div class="result">
                                <div class="left">
                                    <div class="loan-emi">
                                        <h3>Monthly EMI</h3>
                                        <div class="value">123</div>
                                    </div>

                                    <div class="total-interest">
                                        <h3>Total Interest Payable</h3>
                                        <div class="value">1234</div>
                                    </div>

                                    <div class="total-amount">
                                        <h3>Total Amount</h3>
                                        <div class="value">12345</div>
                                    </div>

                                    <button class="calculate-btn">Calculate</button>
                                </div>

                                <div class="right">
                                    <canvas id="myChart" width="400" height="400"></canvas>
                                    <p>T & C Apply*</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>