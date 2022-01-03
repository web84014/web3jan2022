<?php
// Preventing to direct access
defined( 'ABSPATH' ) OR die( 'Direct access not acceptable!' );

if ( ! function_exists( 'wws_time_hours_dropdown' ) ) {

	function wws_time_hours_dropdown( $attr ) {

		$name     = ( isset( $attr['name'] ) ) ? "name='{$attr['name']}'" : '';
		$class    = ( isset( $attr['class'] ) ) ? "class='{$attr['class']}'" : '';
		$selected = ( isset( $attr['selected'] ) ) ? $attr['selected'] : '';

		$select = '';
		$select .= '<select ' . $class . ' ' . $name . '  >
			<option value="00" ' . selected( '00', $selected, false ) . ' >00</option>
			<option value="01" ' . selected( '01', $selected, false ) . ' >01</option>
			<option value="02" ' . selected( '02', $selected, false ) . ' >02</option>
			<option value="03" ' . selected( '03', $selected, false ) . ' >03</option>
			<option value="04" ' . selected( '04', $selected, false ) . ' >04</option>
			<option value="05" ' . selected( '05', $selected, false ) . ' >05</option>
			<option value="06" ' . selected( '06', $selected, false ) . ' >06</option>
			<option value="07" ' . selected( '07', $selected, false ) . ' >07</option>
			<option value="08" ' . selected( '08', $selected, false ) . ' >08</option>
			<option value="09" ' . selected( '09', $selected, false ) . ' >09</option>
			<option value="10" ' . selected( '10', $selected, false ) . ' >10</option>
			<option value="11" ' . selected( '11', $selected, false ) . ' >11</option>
			<option value="12" ' . selected( '12', $selected, false ) . ' >12</option>
			<option value="13" ' . selected( '13', $selected, false ) . ' >13</option>
			<option value="14" ' . selected( '14', $selected, false ) . ' >14</option>
			<option value="15" ' . selected( '15', $selected, false ) . ' >15</option>
			<option value="16" ' . selected( '16', $selected, false ) . ' >16</option>
			<option value="17" ' . selected( '17', $selected, false ) . ' >17</option>
			<option value="18" ' . selected( '18', $selected, false ) . ' >18</option>
			<option value="19" ' . selected( '19', $selected, false ) . ' >19</option>
			<option value="20" ' . selected( '20', $selected, false ) . ' >20</option>
			<option value="21" ' . selected( '21', $selected, false ) . ' >21</option>
			<option value="22" ' . selected( '22', $selected, false ) . ' >22</option>
			<option value="23" ' . selected( '23', $selected, false ) . ' >23</option>
		</select>';

		echo $select;

	}

}

if ( ! function_exists( 'wws_time_minutes_dropdown' ) ) {

	function wws_time_minutes_dropdown( $attr ) {

		$name     = ( isset( $attr['name'] ) ) ? "name='{$attr['name']}'" : '';
		$class    = ( isset( $attr['class'] ) ) ? "class='{$attr['class']}'" : '';
		$selected = ( isset( $attr['selected'] ) ) ? $attr['selected'] : '';

		$select = '';
		$select .= '<select ' . $class . ' ' . $name . '  >
			<option value="00" ' . selected('00', $selected, false ) . ' >00</option>
			<option value="01" ' . selected('01', $selected, false ) . ' >01</option>
			<option value="02" ' . selected('02', $selected, false ) . ' >02</option>
			<option value="03" ' . selected('03', $selected, false ) . ' >03</option>
			<option value="04" ' . selected('04', $selected, false ) . ' >04</option>
			<option value="05" ' . selected('05', $selected, false ) . ' >05</option>
			<option value="06" ' . selected('06', $selected, false ) . ' >06</option>
			<option value="07" ' . selected('07', $selected, false ) . ' >07</option>
			<option value="08" ' . selected('08', $selected, false ) . ' >08</option>
			<option value="09" ' . selected('09', $selected, false ) . ' >09</option>
			<option value="10" ' . selected('10', $selected, false ) . ' >10</option>
			<option value="11" ' . selected('11', $selected, false ) . ' >11</option>
			<option value="12" ' . selected('12', $selected, false ) . ' >12</option>
			<option value="13" ' . selected('13', $selected, false ) . ' >13</option>
			<option value="14" ' . selected('14', $selected, false ) . ' >14</option>
			<option value="15" ' . selected('15', $selected, false ) . ' >15</option>
			<option value="16" ' . selected('16', $selected, false ) . ' >16</option>
			<option value="17" ' . selected('17', $selected, false ) . ' >17</option>
			<option value="18" ' . selected('18', $selected, false ) . ' >18</option>
			<option value="19" ' . selected('19', $selected, false ) . ' >19</option>
			<option value="20" ' . selected('20', $selected, false ) . ' >20</option>
			<option value="21" ' . selected('21', $selected, false ) . ' >21</option>
			<option value="22" ' . selected('22', $selected, false ) . ' >22</option>
			<option value="23" ' . selected('23', $selected, false ) . ' >23</option>
			<option value="24" ' . selected('24', $selected, false ) . ' >24</option>
			<option value="25" ' . selected('25', $selected, false ) . ' >25</option>
			<option value="26" ' . selected('26', $selected, false ) . ' >26</option>
			<option value="27" ' . selected('27', $selected, false ) . ' >27</option>
			<option value="28" ' . selected('28', $selected, false ) . ' >28</option>
			<option value="29" ' . selected('29', $selected, false ) . ' >29</option>
			<option value="30" ' . selected('30', $selected, false ) . ' >30</option>
			<option value="31" ' . selected('31', $selected, false ) . ' >31</option>
			<option value="32" ' . selected('32', $selected, false ) . ' >32</option>
			<option value="33" ' . selected('33', $selected, false ) . ' >33</option>
			<option value="34" ' . selected('34', $selected, false ) . ' >34</option>
			<option value="35" ' . selected('35', $selected, false ) . ' >35</option>
			<option value="36" ' . selected('36', $selected, false ) . ' >36</option>
			<option value="37" ' . selected('37', $selected, false ) . ' >37</option>
			<option value="38" ' . selected('38', $selected, false ) . ' >38</option>
			<option value="39" ' . selected('39', $selected, false ) . ' >39</option>
			<option value="40" ' . selected('40', $selected, false ) . ' >40</option>
			<option value="41" ' . selected('41', $selected, false ) . ' >41</option>
			<option value="42" ' . selected('42', $selected, false ) . ' >42</option>
			<option value="43" ' . selected('43', $selected, false ) . ' >43</option>
			<option value="44" ' . selected('44', $selected, false ) . ' >44</option>
			<option value="45" ' . selected('45', $selected, false ) . ' >45</option>
			<option value="46" ' . selected('46', $selected, false ) . ' >46</option>
			<option value="47" ' . selected('47', $selected, false ) . ' >47</option>
			<option value="48" ' . selected('48', $selected, false ) . ' >48</option>
			<option value="49" ' . selected('49', $selected, false ) . ' >49</option>
			<option value="50" ' . selected('50', $selected, false ) . ' >50</option>
			<option value="51" ' . selected('51', $selected, false ) . ' >51</option>
			<option value="52" ' . selected('52', $selected, false ) . ' >52</option>
			<option value="53" ' . selected('53', $selected, false ) . ' >53</option>
			<option value="54" ' . selected('54', $selected, false ) . ' >54</option>
			<option value="55" ' . selected('55', $selected, false ) . ' >55</option>
			<option value="56" ' . selected('56', $selected, false ) . ' >56</option>
			<option value="57" ' . selected('57', $selected, false ) . ' >57</option>
			<option value="58" ' . selected('58', $selected, false ) . ' >58</option>
			<option value="59" ' . selected('59', $selected, false ) . ' >59</option>
		</select>';

		echo $select;
	}

}
