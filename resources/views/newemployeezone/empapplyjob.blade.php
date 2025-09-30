@extends('newemployeezone.layout')

@section('title')
VGN Projects Estates Pvt Ltd |Employee Zone| Employee refer apply job Page
@endsection

@section('description')
    <meta name="description" content="">
@endsection

@section('keyword')  
@endsection


@section('style')
@include('newemployeezone.styles.commoncss')
 <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/newcustomerzoneassets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
<style>
	.carousel-inner>.item>img
	{
		min-height: 280px;
	}
    #changedetailsForm label.col-sm-2 {
        font-weight: normal;
    }
</style>
<script>
    function isNumberKey(evt)
			{
				var charCode = (evt.which) ? evt.which : event.keyCode
				if (charCode > 31 && (charCode < 48 || charCode > 57))
                return false;
				
				return true;
			}
			function checkNum()
			{
				if ((event.keyCode > 64 && event.keyCode < 91) || (event.keyCode > 96 && event.keyCode < 123) || event.keyCode == 8 || event.keyCode == 46 || event.keyCode == 32)
				return true;
				else
				{
					return false;
				}
			}
    
    var populatecert = function (grad, target_id) {
        
				// delcare our function variables
				var i = 0, options, cert, selection, target;
				
				// our available cert per grad, stored as JSON
				cert = {
					"Non-SSC": {
						"Non-SSC": "Non-SSC"
					},
					"SSC": {
						"SSC": "SSC"
					},
					"ITI": {
						"ITI": "ITI",
						"ITI(Auto Electrician)": "ITI(Auto Electrician)",
						"ITI(Carpentry)": "ITI(Carpentry)",
						"ITI": "ITI(Computer Hardware)",
						"ITI(Computer Hardware)": "ITI(Computer Hardware)",
						"ITI(Darftsman)": "ITI(Darftsman)",
						"ITI(Electrical)": "ITI(Electrical)",
						"ITI(Electronic)": "ITI(Electronic)",
						"ITI(Fitter)": "ITI(Fitter)",
						"ITI(ITI)": "ITI(ITI)",
						"ITI(Machinist)": "ITI(Machinist)",
						"ITI": "ITI(Mechanical)",
						"ITI(Mechanical)": "ITI(Mining)",
						"ITI(Survey)": "ITI(Survey)",
						"ITI(Trainig)": "ITI(Trainig)",
						"ITI(Turner)": "ITI(Turner)",
						"ITI(Welding)": "ITI(Welding)",
						"ITI(Wireman)": "ITI(Wireman)",
						"Automobile": "Automobile"
					},
					"HSC": {
						"HSC": "HSC"
					},
					"Diploma": {
						"AMIE (AUTO)": "AMIE (AUTO)",
						"AMIE(Aeronautical Engineering)": "AMIE(Aeronautical Engineering)",
						"AMIE(Agricultural Engineering)": "AMIE(Agricultural Engineering)",
						"AMIE(Architecture)": "AMIE(Architecture)",
						"AMIE(Automobile)": "AMIE(Automobile)",
						"AMIE(Chemical Engineering)": "AMIE(Chemical Engineering)",
						"AMIE(Civil Engineering)": "AMIE(Civil Engineering)",
						"AMIE(Computer Science)": "AMIE(Computer Science)",
						"AMIE(Construction Engineering)": "AMIE(Construction Engineering)",
						"AMIE(Draftsman)": "AMIE(Draftsman)",
						"AMIE(Electrical Engineering)": "AMIE(Electrical Engineering)",
						"AMIE(Electronics & Telecummunition)": "AMIE(Electronics & Telecummunition)",
						"AMIE(Electronics Engineering)": "AMIE(Electronics Engineering)",
						"AMIE(Environmental Engineering)": "AMIE(Environmental Engineering)",
						"AMIE(Fabrication & Errection Engineering": "AMIE(Fabrication & Errection Engineering",
						"AMIE(Foundation Engineering)": "AMIE(Foundation Engineering)",
						"AMIE(Geological Engineering)": "AMIE(Geological Engineering)",
						"AMIE(Hydrolics Engineering)": "AMIE(Hydrolics Engineering)",
						"AMIE(Industrial Electronis Engineering)": "AMIE(Industrial Electronis Engineering)",
						"AMIE(Industrial Engineering)": "AMIE(Industrial Engineering)",
						"AMIE(Information Technology)": "AMIE(Information Technology)",
						"AMIE(Instrumentation Engineering)": "AMIE(Instrumentation Engineering)",
						"AMIE(Marine Engineering)": "AMIE(Marine Engineering)",
						"AMIE(Mechanical Engineering)": "AMIE(Mechanical Engineering)",
						"AMIE(Metallurgical Engineering)": "AMIE(Metallurgical Engineering)",
						"AMIE(Mining Engineering)": "AMIE(Mining Engineering)",
						"AMIE(Safety Engineering)": "AMIE(Safety Engineering)",
						"AMIE(Structural Engineering)": "AMIE(Structural Engineering)",
						"AMIE(Survey Engineering)": "AMIE(Survey Engineering)",
						"AMIE(Telecommunication Engineering)": "AMIE(Telecommunication Engineering)",
						"D.E(Aeronautical Engineering)": "D.E(Aeronautical Engineering)",
						"D.E(Agricultural Engineering)": "D.E(Agricultural Engineering)",
						"D.E(Architecture)": "D.E(Architecture)",
						"D.E(Automobile Engineering)": "D.E(Automobile Engineering)",
						"D.E(Chemical Engineering)": "D.E(Chemical Engineering)",
						"D.E(Civil Engineering)": "D.E(Civil Engineering)",
						"D.E(Computer Science)": "D.E(Computer Science)",
						"D.E(Construction Engineering)": "D.E(Construction Engineering)",
						"D.E(Draftsman)": "D.E(Draftsman)",
						"D.E(Drilling  Engineering)": "D.E(Drilling  Engineering)",
						"D.E(Electrical Engineering)": "D.E(Electrical Engineering)",
						"D.E(Electronics & Telecummunition)": "D.E(Electronics & Telecummunition)",
						"D.E(Electronics Engineering)": "D.E(Electronics Engineering)",
						"D.E(Environmental Engineering)": "D.E(Environmental Engineering)",
						"D.E(Fabrication & Errection Engineering)": "D.E(Fabrication & Errection Engineering)",
						"D.E(Foundation Engineering)": "D.E(Foundation Engineering)",
						"D.E(Geological Engineering)": "D.E(Geological Engineering)",
						"D.E(Hydrolics Engineering)": "D.E(Hydrolics Engineering)",
						"D.E(Industrial Electronis Engineering)": "D.E(Industrial Electronis Engineering)",
						"Diploma": "D.E(Industrial Engineering)",
						"D.E(Industrial Engineering)": "D.E(Information Technology)",
						"D.E(Instrumentation Engineering)": "D.E(Instrumentation Engineering)",
						"D.E(Marine Engineering)": "D.E(Marine Engineering)",
						"D.E(Mechanical Engineering)": "D.E(Mechanical Engineering)",
						"D.E(Metallurgical Engineering)": "D.E(Metallurgical Engineering)",
						"D.E(Mining Engineering)": "D.E(Mining Engineering)",
						"D.E(Perto Chemical  Engineering)": "D.E(Perto Chemical  Engineering)",
						"D.E(Plant & Maint. Engineering)": "D.E(Plant & Maint. Engineering)",
						"D.E(Polymer  Engineering)": "D.E(Polymer  Engineering)",
						"D.E(Power  Engineering)": "D.E(Power  Engineering)",
						"D.E(Road technology)": "D.E(Road technology)",
						"D.E(Safety Engineering)": "D.E(Safety Engineering)",
						"D.E(Structural Engineering)": "D.E(Structural Engineering)",
						"D.E(Survey Engineering)": "D.E(Survey Engineering)",
						"D.E(Telecommunication Engineering)": "D.E(Telecommunication Engineering)",
						"D.E(Tool  Engineering)": "D.E(Tool  Engineering)",
						"D.E(Transport  Engineering)": "D.E(Transport  Engineering)",
						"DIP IN  MANAGEMENT STUDIES": "DIP IN  MANAGEMENT STUDIES",
						"DIP IN  TAXATION LAW": "DIP IN  TAXATION LAW",
						"DIP(Advertisement & Production)": "DIP(Advertisement & Production)",
						"DIP(Auto CAD)": "DIP(Auto CAD)",
						"DIP(Business Administratiom)": "DIP(Business Administratiom)",
						"DIP(Business Management)": "DIP(Business Management)",
						"DIP(Computer Application)": "DIP(Computer Application)",
						"DIP(Construction Management)": "DIP(Construction Management)",
						"DIP(Contarcts Management)": "DIP(Contarcts Management)",
						"DIP(Environment Management)": "DIP(Environment Management)",
						"DIP(Export & IMPORT)": "DIP(Export & IMPORT)",
						"DIP(Finance Management)": "DIP(Finance Management)",
						"DIP(Hospital Management)": "DIP(Hospital Management)",
						"DIP(Hotel Management)": "DIP(Hotel Management)",
						"DIP(Human Resources Management)": "DIP(Human Resources Management)",
						"DIP(Industrial Management)": "DIP(Industrial Management)",
						"DIP(Industrial Structure)": "DIP(Industrial Structure)",
						"DIP(Journalisam)": "DIP(Journalisam)",
						"DIP(Labour Law & Labour Welfare)": "DIP(Labour Law & Labour Welfare)",
						"DIP(Marketing Management)": "DIP(Marketing Management)",
						"DIP(Mass Comminication)": "DIP(Mass Comminication)",
						"DIP(Mass Comminication)": "DIP(Mass Comminication)",
						"DIP(Material Management)": "DIP(Material Management)",
						"DIP(Operations and Production Management": "DIP(Operations and Production Management",
						"DIP(Personnal Management & Industrial Re": "DIP(Personnal Management & Industrial Re",
						"DIP(Personnal Management)": "DIP(Personnal Management)",
						"DIP(Quality Management)": "DIP(Quality Management)",
						"DIP(Rail Way)": "DIP(Rail Way)",
						"DIP(Safety)": "DIP(Safety)",
						"DIP(Secretary)": "DIP(Secretary)",
						"DIP(Stores)": "DIP(Stores)",
						"DIP(Systems Management)": "DIP(Systems Management)",
						"Material Management": "Material Management",
						"Mechanical": "Mechanical",
						"AutoCAD": "AutoCAD",
						"Draftsman(Civil)": "Draftsman(Civil)",
						"Draftsman(Mechanical)": "Draftsman(Mechanical)",
						"Information Technology": "Information Technology",
						"Cert. Cou.(Computer)": "Cert. Cou.(Computer)",
						"Cert. Cou.(Secretary)": "Cert. Cou.(Secretary)",
						"Cert. Cou.(Typing)": "Cert. Cou.(Typing)",
						"Dip (Marketing Management)": "Dip (Marketing Management)",
						"DIP(Shorthand)": "DIP(Shorthand)"
					},
					"Graduate": {
						"B.A": "B.A",
						"B.A(Catering Technology)": "B.A(Catering Technology)",
						"B.A(Corporate)": "B.A(Corporate)",
						"B.A(Defence)": "B.A(Defence)",
						"B.A(Design Arts)": "B.A(Design Arts)",
						"B.A(Economics)": "B.A(Economics)",
						"B.A(English)": "B.A(English)",
						"B.A(Fisheries)": "B.A(Fisheries)",
						"B.A(Geography)": "B.A(Geography)",
						"B.A(Humanities)": "B.A(Humanities)",
						"B.A(Industrial Relation)": "B.A(Industrial Relation)",
						"B.A(Journalisim)": "B.A(Journalisim)",
						"B.A(Performing Arts)": "B.A(Performing Arts)",
						"B.A(Personnal)": "B.A(Personnal)",
						"B.A(Physical Education)": "B.A(Physical Education)",
						"B.A(Political Science)": "B.A(Political Science)",
						"B.A(Psycology)": "B.A(Psycology)",
						"B.A(Public Relation)": "B.A(Public Relation)",
						"B.A(Social Welfare)": "B.A(Social Welfare)",
						"B.A(Socialogy)": "B.A(Socialogy)",
						"B.A(Travel and Tourism)": "B.A(Travel and Tourism)",
						"B.A(Visual Arts)": "B.A(Visual Arts)",
						"B.Com": "B.Com",
						"B.Com(Costing)": "B.Com(Costing)",
						"B.E(Aeronautical Engineering)": "B.E(Aeronautical Engineering)",
						"B.E(Agricultural Engineering)": "B.E(Agricultural Engineering)",
						"B.E(Architecture)": "B.E(Architecture)",
						"B.E(Automobile)": "B.E(Automobile)",
						"B.E(Chemical Engineering)": "B.E(Chemical Engineering)",
						"B.E(Civil Engineering)": "B.E(Civil Engineering)",
						"B.E(Computer Science)": "B.E(Computer Science)",
						"B.E(Construction Engineering)": "B.E(Construction Engineering)",
						"B.E(Draftsman)": "B.E(Draftsman)",
						"B.E(Electrical Engineering)": "B.E(Electrical Engineering)",
						"B.E(Electronics & Telecummunition)": "B.E(Electronics & Telecummunition)",
						"B.E(Electronics Engineering)": "B.E(Electronics Engineering)",
						"B.E(Environmental Engineering)": "B.E(Environmental Engineering)",
						"B.E(Fabrication & Errection Engineering)": "B.E(Fabrication & Errection Engineering)",
						"B.E(Foundation Engineering)": "B.E(Foundation Engineering)",
						"B.E(Geological Engineering)": "B.E(Geological Engineering)",
						"B.E(Hydrolics Engineering)": "B.E(Hydrolics Engineering)",
						"B.E(Industrial Electronis Engineering)": "B.E(Industrial Electronis Engineering)",
						"B.E(Industrial Engineering)": "B.E(Industrial Engineering)",
						"B.E(Information Technology)": "B.E(Information Technology)",
						"B.E(Instrumentation Engineering)": "B.E(Instrumentation Engineering)",
						"B.E(Marine Engineering)": "B.E(Marine Engineering)",
						"B.E(Material Management)": "B.E(Material Management)",
						"B.E(Mechanical Engineering)": "B.E(Mechanical Engineering)",
						"B.E(Metallurgical Engineering)": "B.E(Metallurgical Engineering)",
						"B.E(Mining Engineering)": "B.E(Mining Engineering)",
						"B.E(Power  Engineering)": "B.E(Power  Engineering)",
						"B.E(Power)": "B.E(Power)",
						"B.E(Production)": "B.E(Production)",
						"B.E(Production)": "B.E(Production)",
						"B.E(Production)": "B.E(Production)",
						"B.E(Road technology)": "B.E(Road technology)",
						"Graduate": "B.E(Safety Engineering)",
						"B.E(Safety Engineering)": "B.E(Structural Engineering)",
						"B.E(Survey Engineering)": "B.E(Survey Engineering)",
						"B.E(Telecommunication Engineering)": "B.E(Telecommunication Engineering)",
						"B.Sc(Aeronautical Engineering)": "B.Sc(Aeronautical Engineering)",
						"B.Sc(Agricultural Engineering)": "B.Sc(Agricultural Engineering)",
						"B.Sc(Agricultural)": "B.Sc(Agricultural)",
						"B.Sc(Architecture)": "B.Sc(Architecture)",
						"B.Sc(Automobile Engineering)": "B.Sc(Automobile Engineering)",
						"B.Sc(Bio Chemistry)": "B.Sc(Bio Chemistry)",
						"B.Sc(Botony)": "B.Sc(Botony)",
						"B.Sc(Chemical Engineering)": "B.Sc(Chemical Engineering)",
						"B.Sc(Chemistry)": "B.Sc(Chemistry)",
						"B.Sc(Civil Engineering)": "B.Sc(Civil Engineering)",
						"B.Sc(Computer Science)": "B.Sc(Computer Science)",
						"B.Sc(Computer)": "B.Sc(Computer)",
						"B.Sc(Construction Engineering)": "B.Sc(Construction Engineering)",
						"B.Sc(Draftsman)": "B.Sc(Draftsman)",
						"B.Sc(Drilling  Engineering)": "B.Sc(Drilling  Engineering)",
						"B.Sc(Economics)": "B.Sc(Economics)",
						"B.Sc(Electrical Engineering)": "B.Sc(Electrical Engineering)",
						"B.Sc(Electronics & Telecummunition)": "B.Sc(Electronics & Telecummunition)",
						"B.Sc(Electronics Engineering)": "B.Sc(Electronics Engineering)",
						"B.Sc(Environmental Engineering)": "B.Sc(Environmental Engineering)",
						"B.Sc(Fabrication & Errection Engineering": "B.Sc(Fabrication & Errection Engineering",
						"B.Sc(Foundation Engineering)": "B.Sc(Foundation Engineering)",
						"B.Sc(Geological Engineering)": "B.Sc(Geological Engineering)",
						"B.Sc(Geology)": "B.Sc(Geology)",
						"B.Sc(Home Science)": "B.Sc(Home Science)",
						"B.Sc(Hydrolics Engineering)": "B.Sc(Hydrolics Engineering)",
						"B.Sc(Industrial Electronis Engineering)": "B.Sc(Industrial Electronis Engineering)",
						"B.Sc(Industrial Engineering)": "B.Sc(Industrial Engineering)",
						"B.Sc(Information Technology)": "B.Sc(Information Technology)",
						"B.Sc(Instrumentation Engineering)": "B.Sc(Instrumentation Engineering)",
						"B.Sc(Marine Engineering)": "B.Sc(Marine Engineering)",
						"B.Sc(Mathematics)": "B.Sc(Mathematics)",
						"B.Sc(Mechanical Engineering)": "B.Sc(Mechanical Engineering)",
						"B.Sc(Metallurgical Engineering)": "B.Sc(Metallurgical Engineering)",
						"B.Sc(Mining Engineering)": "B.Sc(Mining Engineering)",
						"B.Sc(Perto Chemical  Engineering)": "B.Sc(Perto Chemical  Engineering)",
						"B.Sc(Physics)": "B.Sc(Physics)",
						"B.Sc(Plant & Maint. Engineering)": "B.Sc(Plant & Maint. Engineering)",
						"B.Sc(Polymer  Engineering)": "B.Sc(Polymer  Engineering)",
						"B.Sc(Power  Engineering)": "B.Sc(Power  Engineering)",
						"B.Sc(Production Engineering)": "B.Sc(Production Engineering)",
						"B.Sc(Sciences)": "B.Sc(Sciences)",
						"B.Sc(Statistics)": "B.Sc(Statistics)",
						"B.Sc(Structural Engineering)": "B.Sc(Structural Engineering)",
						"B.Sc(Survey Engineering)": "B.Sc(Survey Engineering)",
						"B.Sc(Telecommunication Engineering)": "B.Sc(Telecommunication Engineering)",
						"B.Sc(Tool  Engineering": "B.Sc(Tool  Engineering",
						"B.Sc(Transport  Engineering)": "B.Sc(Transport  Engineering)",
						"B.Sc(Zoology)": "B.Sc(Zoology)",
						"B.Tech(Aeronautical Engineering)": "B.Tech(Aeronautical Engineering)",
						"B.Tech(Agricultural Engineering)": "B.Tech(Agricultural Engineering)",
						"B.Tech(Architecture)": "B.Tech(Architecture)",
						"B.Tech(Automobile Engineering)": "B.Tech(Automobile Engineering)",
						"B.Tech(Chemical Engineering)": "B.Tech(Chemical Engineering)",
						"B.Tech(Civil Engineering)": "B.Tech(Civil Engineering)",
						"B.Tech(Computer Science)": "B.Tech(Computer Science)",
						"B.Tech(Construction Engineering)": "B.Tech(Construction Engineering)",
						"B.Tech(Draftsman)": "B.Tech(Draftsman)",
						"B.Tech(Drilling  Engineering)": "B.Tech(Drilling  Engineering)",
						"B.Tech(Electrical Engineering)": "B.Tech(Electrical Engineering)",
						"B.Tech(Electronics & Telecummunition)": "B.Tech(Electronics & Telecummunition)",
						"B.Tech(Electronics Engineering)": "B.Tech(Electronics Engineering)",
						"B.Tech(Environmental Engineering)": "B.Tech(Environmental Engineering)",
						"B.Tech(Fabrication & Errection Engineering)": "B.Tech(Fabrication & Errection Engineering)",
						"B.Tech(Foundation Engineering)": "B.Tech(Foundation Engineering)",
						"B.Tech(Geological Engineering)": "B.Tech(Geological Engineering)",
						"B.Tech(Hydrolics Engineering)": "B.Tech(Hydrolics Engineering)",
						"B.Tech(Industrial Electronis Engineering": "B.Tech(Industrial Electronis Engineering",
						"B.Tech(Industrial Engineering)": "B.Tech(Industrial Engineering)",
						"B.Tech(Information Technology)": "B.Tech(Information Technology)",
						"B.Tech(Instrumentation Engineering)": "B.Tech(Instrumentation Engineering)",
						"B.Tech(Mechanical Engineering)": "B.Tech(Mechanical Engineering)",
						"B.Tech(Metallurgical Engineering)": "B.Tech(Metallurgical Engineering)",
						"B.Tech(Mining Engineering)": "B.Tech(Mining Engineering)",
						"B.Tech(Perto Chemical  Engineering)": "B.Tech(Perto Chemical  Engineering)",
						"B.Tech(Plant & Maint. Engineering)": "B.Tech(Plant & Maint. Engineering)",
						"B.Tech(Polymer  Engineering)": "B.Tech(Polymer  Engineering)",
						"B.Tech(Power  Engineering)": "B.Tech(Power  Engineering)",
						"B.Tech(Road technology)": "B.Tech(Road technology)",
						"B.Tech(Safety Engineering)": "B.Tech(Safety Engineering)",
						"B.Tech(Structural Engineering)": "B.Tech(Structural Engineering)",
						"B.Tech(Survey Engineering)": "B.Tech(Survey Engineering)",
						"B.Tech(Telecommunication Engineering)": "B.Tech(Telecommunication Engineering)",
						"B.Tech(Tool  Engineering)": "B.Tech(Tool  Engineering)",
						"B.Tech(Transport  Engineering)": "B.Tech(Transport  Engineering)",
						"Bachelor of Business Administraion": "Bachelor of Business Administraion",
						"Bachelor of Business Management": "Bachelor of Business Management",
						"Bachelor of Computer Application": "Bachelor of Computer Application",
						"Bachelor of Computer Science": "Bachelor of Computer Science",
						"Bachelor of Labour Management": "Bachelor of Labour Management",
						"LLB": "LLB",
						"B.Ed.": "B.Ed.",
						"B.Sc. (PCM)": "B.Sc. (PCM)",
						"B.Sc.": "B.Sc.",
						"B.Tech.": "B.Tech.",
						"B.Sc. (Honours)": "B.Sc. (Honours)",
						"B.Com (Honours)": "B.Com (Honours)",
						"B.E. (Production Engg. & Indl. Mgmt.)": "B.E. (Production Engg. & Indl. Mgmt.)",
						"B.E. (Railway Engineering)": "B.E. (Railway Engineering)",
						"LME (Licenciate Mechanical Engineering)": "LME (Licenciate Mechanical Engineering)"
					},
					"Post Graduate": {
						"M.A": "M.A",
						"M.A(Catering Technology)": "M.A(Catering Technology)",
						"M.A(Corporate)": "M.A(Corporate)",
						"M.A(Defence)": "M.A(Defence)",
						"M.A(Design Arts)": "M.A(Design Arts)",
						"M.A(Economics)": "M.A(Economics)",
						"M.A(English)": "M.A(English)",
						"M.A(Fisheries)": "M.A(Fisheries)",
						"M.A(Humanities)": "M.A(Humanities)",
						"M.A(Industrial Relation)": "M.A(Industrial Relation)",
						"M.A(Journalisim)": "M.A(Journalisim)",
						"M.A(Performing Arts)": "M.A(Performing Arts)",
						"M.A(Personnal)": "M.A(Personnal)",
						"M.A(Physical Education)": "M.A(Physical Education)",
						"M.A(Political Science)": "M.A(Political Science)",
						"M.A(Psycology)": "M.A(Psycology)",
						"M.A(Public Relation)": "M.A(Public Relation)",
						"M.A(Social Welfare)": "M.A(Social Welfare)",
						"M.A(Socialogy)": "M.A(Socialogy)",
						"M.A(Travel and Tourism)": "M.A(Travel and Tourism)",
						"M.A(Visual Arts)": "M.A(Visual Arts)",
						"M.Com": "M.Com",
						"M.Com(Costing)": "M.Com(Costing)",
						"M.E(Aeronautical Engineering)": "M.E(Aeronautical Engineering)",
						"M.E(Agricultural Engineering)": "M.E(Agricultural Engineering)",
						"M.E(Architecture)": "M.E(Architecture)",
						"M.E(Automobile Engineering)": "M.E(Automobile Engineering)",
						"M.E(Chemical Engineering)": "M.E(Chemical Engineering)",
						"M.E(Civil Engineering)": "M.E(Civil Engineering)",
						"M.E(Computer Science)": "M.E(Computer Science)",
						"M.E(Construction Engineering)": "M.E(Construction Engineering)",
						"M.E(Draftsman)": "M.E(Draftsman)",
						"M.E(Drilling  Engineering)": "M.E(Drilling  Engineering)",
						"M.E(Electrical Engineering)": "M.E(Electrical Engineering)",
						"M.E(Electronics & Telecummunition)": "M.E(Electronics & Telecummunition)",
						"M.E(Electronics Engineering)": "M.E(Electronics Engineering)",
						"M.E(Environmental Engineering)": "M.E(Environmental Engineering)",
						"M.E(Fabrication & Errection Engineering)": "M.E(Fabrication & Errection Engineering)",
						"M.E(Foundation Engineering)": "M.E(Foundation Engineering)",
						"M.E(Geological Engineering)": "M.E(Geological Engineering)",
						"M.E(Hydrolics Engineering)": "M.E(Hydrolics Engineering)",
						"M.E(Industrial Electronis Engineering)": "M.E(Industrial Electronis Engineering)",
						"M.E(Industrial Engineering)": "M.E(Industrial Engineering)",
						"M.E(Information Technology)": "M.E(Information Technology)",
						"M.E(Instrumentation Engineering)": "M.E(Instrumentation Engineering)",
						"M.E(Marine Engineering)": "M.E(Marine Engineering)",
						"M.E(Mechanical Engineering)": "M.E(Mechanical Engineering)",
						"M.E(Metallurgical Engineering)": "M.E(Metallurgical Engineering)",
						"M.E(Mining Engineering)": "M.E(Mining Engineering)",
						"M.E(Perto Chemical  Engineering)": "M.E(Perto Chemical  Engineering)",
						"M.E(Plant & Maint. Engineering)": "M.E(Plant & Maint. Engineering)",
						"M.E(Polymer  Engineering)": "M.E(Polymer  Engineering)",
						"M.E(Power  Engineering)": "M.E(Power  Engineering)",
						"M.E(Road technology)": "M.E(Road technology)",
						"M.E(Safety Engineering)": "M.E(Safety Engineering)",
						"M.E(Soil Engineering)": "M.E(Soil Engineering)",
						"M.E(Structural Engineering)": "M.E(Structural Engineering)",
						"M.E(Survey Engineering)": "M.E(Survey Engineering)",
						"M.E(Telecommunication Engineering)": "M.E(Telecommunication Engineering)",
						"M.E(Tool  Engineering)": "M.E(Tool  Engineering)",
						"M.E(Transport  Engineering)": "M.E(Transport  Engineering)",
						"M.Philo(Geology)": "M.Philo(Geology)",
						"M.Sc(Aeronautical Engineering)": "M.Sc(Aeronautical Engineering)",
						"M.Sc(Agricultural Engineering)": "M.Sc(Agricultural Engineering)",
						"M.Sc(Agricultural)": "M.Sc(Agricultural)",
						"M.Sc(Architecture)": "M.Sc(Architecture)",
						"M.Sc(Automobile Engineering)": "M.Sc(Automobile Engineering)",
						"M.Sc(Bio Chemistry)": "M.Sc(Bio Chemistry)",
						"M.Sc(Botony)": "M.Sc(Botony)",
						"M.Sc(Chemical Engineering)": "M.Sc(Chemical Engineering)",
						"M.Sc(Chemistry)": "M.Sc(Chemistry)",
						"M.Sc(Civil Engineering)": "M.Sc(Civil Engineering)",
						"M.Sc(Computer Science)": "M.Sc(Computer Science)",
						"M.Sc(Computer)": "M.Sc(Computer)",
						"M.Sc(Construction Engineering)": "M.Sc(Construction Engineering)",
						"M.Sc(Draftsman)": "M.Sc(Draftsman)",
						"M.Sc(Drilling  Engineering)": "M.Sc(Drilling  Engineering)",
						"M.Sc(Economics)": "M.Sc(Economics)",
						"M.Sc(Electrical Engineering)": "M.Sc(Electrical Engineering)",
						"M.Sc(Electronics & Telecummunition)": "M.Sc(Electronics & Telecummunition)",
						"M.Sc(Electronics Engineering)": "M.Sc(Electronics Engineering)",
						"M.Sc(Environmental Engineering)": "M.Sc(Environmental Engineering)",
						"M.Sc(Fabrication & Errection Engineering": "M.Sc(Fabrication & Errection Engineering",
						"M.Sc(Foundation Engineering)": "M.Sc(Foundation Engineering)",
						"M.Sc(Geological Engineering)": "M.Sc(Geological Engineering)",
						"M.Sc(Geology)": "M.Sc(Geology)",
						"M.Sc(Home Science)": "M.Sc(Home Science)",
						"M.Sc(Hydrolics Engineering)": "M.Sc(Hydrolics Engineering)",
						"M.Sc(Industrial Electronis Engineering)": "M.Sc(Industrial Electronis Engineering)",
						"M.Sc(Industrial Engineering)": "M.Sc(Industrial Engineering)",
						"M.Sc(Information Technology)": "M.Sc(Information Technology)",
						"M.Sc(Instrumentation Engineering)": "M.Sc(Instrumentation Engineering)",
						"M.Sc(Marine Engineering)": "M.Sc(Marine Engineering)",
						"M.Sc(Mathematics)": "M.Sc(Mathematics)",
						"M.Sc(Mechanical Engineering)": "M.Sc(Mechanical Engineering)",
						"M.Sc(Metallurgical Engineering)": "M.Sc(Metallurgical Engineering)",
						"M.Sc(Mining Engineering)": "M.Sc(Mining Engineering)",
						"M.Sc(Perto Chemical  Engineering)": "M.Sc(Perto Chemical  Engineering)",
						"M.Sc(Physics)": "M.Sc(Physics)",
						"M.Sc(Plant & Maint. Engineering)": "M.Sc(Plant & Maint. Engineering)",
						"M.Sc(Polymer  Engineering)": "M.Sc(Polymer  Engineering)",
						"M.Sc(Power  Engineering)": "M.Sc(Power  Engineering)",
						"M.Sc(Psychology)": "M.Sc(Psychology)",
						"M.Sc(Safety Engineering)": "M.Sc(Safety Engineering)",
						"M.Sc(Sciences)": "M.Sc(Sciences)",
						"M.Sc(Statistics)": "M.Sc(Statistics)",
						"M.Sc(Structural Engineering)": "M.Sc(Structural Engineering)",
						"M.Sc(Telecommunication Engineering)": "M.Sc(Telecommunication Engineering)",
						"M.Sc(Tool  Engineering)": "M.Sc(Tool  Engineering)",
						"M.Sc(Transport  Engineering)": "M.Sc(Transport  Engineering)",
						"M.Sc(Transport  Engineering)": "M.Sc(Transport  Engineering)",
						"M.Sc(Zoology)": "M.Sc(Zoology)",
						"M.TEC(Water Reso. engg)": "M.TEC(Water Reso. engg)",
						"M.Tech(Aeronautical Engineering)": "M.Tech(Aeronautical Engineering)",
						"M.Tech(Agricultural Engineering)": "M.Tech(Agricultural Engineering)",
						"M.Tech(Architecture)": "M.Tech(Architecture)",
						"M.Tech(Automobile Engineering)": "M.Tech(Automobile Engineering)",
						"M.Tech(Chemical Engineering)": "M.Tech(Chemical Engineering)",
						"M.Tech(Civil Engineering)": "M.Tech(Civil Engineering)",
						"M.Tech(Computer Science)": "M.Tech(Computer Science)",
						"M.Tech(Construction Engineering)": "M.Tech(Construction Engineering)",
						"M.Tech(Draftsman)": "M.Tech(Draftsman)",
						"M.Tech(Drilling Engineering)": "M.Tech(Drilling Engineering)",
						"M.Tech(Electrical Engineering)": "M.Tech(Electrical Engineering)",
						"M.Tech(Electronics & Telecummunition)": "M.Tech(Electronics & Telecummunition)",
						"M.Tech(Electronics Engineering)": "M.Tech(Electronics Engineering)",
						"M.Tech(Environmental Engineering)": "M.Tech(Environmental Engineering)",
						"M.Tech(Fabrication & Errection Engineering)": "M.Tech(Fabrication & Errection Engineering)",
						"M.Tech(Foundation Engineering)": "M.Tech(Foundation Engineering)",
						"M.Tech(Geological Engineering)": "M.Tech(Geological Engineering)",
						"M.Tech(Hydrolics Engineering)": "M.Tech(Hydrolics Engineering)",
						"M.Tech(Industrial Electronis Engineering": "M.Tech(Industrial Electronis Engineering",
						"M.Tech(Industrial Engineering)": "M.Tech(Industrial Engineering)",
						"M.Tech(Information Technology)": "M.Tech(Information Technology)",
						"M.Tech(Instrumentation Engineering)": "M.Tech(Instrumentation Engineering)",
						"M.Tech(Marine Engineering)": "M.Tech(Marine Engineering)",
						"M.Tech(Mechanical Engineering)": "M.Tech(Mechanical Engineering)",
						"M.Tech(Metallurgical Engineering)": "M.Tech(Metallurgical Engineering)",
						"M.Tech(Mining Engineering)": "M.Tech(Mining Engineering)",
						"M.Tech(Perto Chemical Engineering)": "M.Tech(Perto Chemical Engineering)",
						"M.Tech(Plant & Maint. Engineering)": "M.Tech(Plant & Maint. Engineering)",
						"M.Tech(Polymer Engineering)": "M.Tech(Polymer Engineering)",
						"M.Tech(Power Engineering)": "M.Tech(Power Engineering)",
						"M.Tech(Road technology)": "M.Tech(Road technology)",
						"M.Tech(Safety Engineering)": "M.Tech(Safety Engineering)",
						"M.Tech(Structural Engineering)": "M.Tech(Structural Engineering)",
						"M.Tech(Telecommunication Engineering)": "M.Tech(Telecommunication Engineering)",
						"M.Tech(Tool Engineering)": "M.Tech(Tool Engineering)",
						"M.Tech(Transport  Engineering)": "M.Tech(Transport  Engineering)",
						"Master in Computer Application": "Master in Computer Application",
						"Master in Computer Science": "Master in Computer Science",
						"Master in Construction Management": "Master in Construction Management",
						"Master in Finance and Costing": "Master in Finance and Costing",
						"Master in Finance Management": "Master in Finance Management",
						"Master in Human Resouses Development": "Master in Human Resouses Development",
						"Master in Information Technology": "Master in Information Technology",
						"Master in Labour Law & Labour Welfare": "Master in Labour Law & Labour Welfare",
						"Master in Labour Studies": "Master in Labour Studies",
						"Master in Material Management": "Master in Material Management",
						"Master in Personnel Management": "Master in Personnel Management",
						"Master in Social Welfare": "Master in Social Welfare",
						"Master of Labour Management": "Master of Labour Management",
						"Material Management": "Material Management",
						"MBA(Advertisement & Production)": "MBA(Advertisement & Production)",
						"MBA(Business Administratiom)": "MBA(Business Administratiom)",
						"MBA(Business Management)": "MBA(Business Management)",
						"MBA(Computer Application)": "MBA(Computer Application)",
						"MBA(Construction Management)": "MBA(Construction Management)",
						"MBA(Contarcts Management)": "MBA(Contarcts Management)",
						"MBA(Economics)": "MBA(Economics)",
						"MBA(Environment Management)": "MBA(Environment Management)",
						"MBA(Finance Management)": "MBA(Finance Management)",
						"MBA(Hospital Management)": "MBA(Hospital Management)",
						"MBA(Hotel Management)": "MBA(Hotel Management)",
						"MBA(Human Resources Management)": "MBA(Human Resources Management)",
						"MBA(Industrial Management)": "MBA(Industrial Management)",
						"MBA(Industrial Relation)": "MBA(Industrial Relation)",
						"MBA(Industrial Structure)": "MBA(Industrial Structure)",
						"MBA(Journalisam)": "MBA(Journalisam)",
						"MBA(Labour Law & Labour Welfare)": "MBA(Labour Law & Labour Welfare)",
						"MBA(Marketing Management)": "MBA(Marketing Management)",
						"MBA(Material Management)": "MBA(Material Management)",
						"MBA(Operations and Production Management": "MBA(Operations and Production Management",
						"MBA(Personnal Management & Industrial Re": "MBA(Personnal Management & Industrial Re",
						"MBA(Personnal Management)": "MBA(Personnal Management)",
						"MBA(Quality Management)": "MBA(Quality Management)",
						"MBA(Systems Management)": "MBA(Systems Management)",
						"MBA(Tourism)": "MBA(Tourism)",
						"MBBS": "MBBS",
						"MCSC": "MCSC",
						"Mechanical": "Mechanical",
						"Medical": "Medical",
						"Metallurgy": "Metallurgy",
						"Mining": "Mining",
						"MMS(Business Administratiom)": "MMS(Business Administratiom)",
						"MMS(Human Resources Management)": "MMS(Human Resources Management)",
						"MMS(Marketing Management)": "MMS(Marketing Management)",
						"MMS(Material Management)": "MMS(Material Management)",
						"MMS(Operations)": "MMS(Operations)",
						"MS(Civil Engineering)": "MS(Civil Engineering)",
						"MS-BY RESEARCH": "MS-BY RESEARCH",
						"Charterd Accountant": "Charterd Accountant",
						"Charterd Accountant - Inter": "Charterd Accountant - Inter",
						"Charterd Financial Anlyst": "Charterd Financial Anlyst",
						"Labour Law & Labour Welfare": "Labour Law & Labour Welfare",
						"Law": "Law",
						"LLB": "LLB",
						"LLM": "LLM",
						"Accounts": "Accounts",
						"ACWA": "ACWA",
						"Advertisements": "Advertisements",
						"Aeronautical": "Aeronautical",
						"Agricultural": "Agricultural",
						"Architecture": "Architecture",
						"Arts": "Arts",
						"Auto Electrician": "Auto Electrician",
						"AutoCAD": "AutoCAD",
						"Automobile": "Automobile",
						"Company Secretary": "Company Secretary",
						"Computer Hardware": "Computer Hardware",
						"Computer Science": "Computer Science",
						"Construction": "Construction",
						"Contracts Management": "Contracts Management",
						"Corporate Operation": "Corporate Operation",
						"Costing": "Costing",
						"CPA": "CPA",
						"Defence": "Defence",
						"Design Arts": "Design Arts",
						"DNIIT": "DNIIT",
						"Draftsman": "Draftsman",
						"Draftsman(Civil)": "Draftsman(Civil)",
						"Draftsman(Mechanical)": "Draftsman(Mechanical)",
						"Drilling": "Drilling",
						"Economics": "Economics",
						"Electrical": "Electrical",
						"Electronics": "Electronics",
						"Electronics & Telecommunication": "Electronics & Telecommunication",
						"English": "English",
						"Environment": "Environment",
						"Export & IMPORT": "Export & IMPORT",
						"Fabrication & Erection": "Fabrication & Erection",
						"Finance Management": "Finance Management",
						"Fisheries": "Fisheries",
						"Fitter": "Fitter",
						"Foundation": "Foundation",
						"GD(Material Management)": "GD(Material Management)",
						"Geography": "Geography",
						"Geology": "Geology",
						"GNIIT": "GNIIT",
						"Higher Secondary Certificate": "Higher Secondary Certificate",
						"Home Science": "Home Science",
						"Human Resources Management": "Human Resources Management",
						"Humanities": "Humanities",
						"Hydraulics": "Hydraulics",
						"Hydrographic survey": "Hydrographic survey",
						"ICWA": "ICWA",
						"ICWA - Inter": "ICWA - Inter",
						"Import & Export": "Import & Export",
						"Industrial Electronics": "Industrial Electronics",
						"Industrial Engineering": "Industrial Engineering",
						"Industrial Management": "Industrial Management",
						"Industrial Pollution": "Industrial Pollution",
						"Industrial Relation": "Industrial Relation",
						"Industrial Relations": "Industrial Relations",
						"Industrial Structure": "Industrial Structure",
						"Information Technology": "Information Technology",
						"Instrumentation": "Instrumentation",
						"Interior Decoration": "Interior Decoration",
						"Journalism": "Journalism",
						"PGDBA (Finance & Mktg.)": "PGDBA (Finance & Mktg.)",
						"PG (Retail & Marketing)": "PG (Retail & Marketing)",
						"PG (Power Management)": "PG (Power Management)",
						"PG (Energy Management)": "PG (Energy Management)",
						"PG (Plastic Testing & Conversion Techno)": "PG (Plastic Testing & Conversion Techno)",
						"LME (Licenciate Mechanical Engineering)": "LME (Licenciate Mechanical Engineering)",
						"PGPMS (Marketing)": "PGPMS (Marketing)",
						"MMS (Marketing)": "MMS (Marketing)"
					},
					"Certificate Course": {
						"MBA(Finance Management)": "MBA(Finance Management)",
						"Information Technology": "Information Technology",
						"Cert. Cou.(ADVTG&MTG)": "Cert. Cou.(ADVTG&MTG)",
						"Cert. Cou.(Auto Cad)": "Cert. Cou.(Auto Cad)",
						"Cert. Cou.(Auto Electrician)": "Cert. Cou.(Auto Electrician)",
						"Cert. Cou.(Basic Naval Trg)": "Cert. Cou.(Basic Naval Trg)",
						"Cert. Cou.(CCNA)": "Cert. Cou.(CCNA)",
						"Cert. Cou.(Civil)": "Cert. Cou.(Civil)",
						"Cert. Cou.(Computer Hardware)": "Cert. Cou.(Computer Hardware)",
						"Cert. Cou.(Computer)": "Cert. Cou.(Computer)",
						"Cert. Cou.(Darftsman)": "Cert. Cou.(Darftsman)",
						"Cert. Cou.(Electrical)": "Cert. Cou.(Electrical)",
						"Cert. Cou.(Electronic)": "Cert. Cou.(Electronic)",
						"Cert. Cou.(Fitter)": "Cert. Cou.(Fitter)",
						"Cert. Cou.(Hydrografic Survey)": "Cert. Cou.(Hydrografic Survey)",
						"Cert. Cou.(Import & Export)": "Cert. Cou.(Import & Export)",
						"Cert. Cou.(Industrial Relation)": "Cert. Cou.(Industrial Relation)",
						"Cert. Cou.(Intiror Decoration)": "Cert. Cou.(Intiror Decoration)",
						"Cert. Cou.(MCSC)": "Cert. Cou.(MCSC)",
						"Cert. Cou.(MEDIA&ADVTG)": "Cert. Cou.(MEDIA&ADVTG)",
						"Cert. Cou.(Mining)": "Cert. Cou.(Mining)",
						"Cert. Cou.(Pharma)": "Cert. Cou.(Pharma)",
						"Cert. Cou.(Secretary)": "Cert. Cou.(Secretary)",
						"Cert. Cou.(Software Development)": "Cert. Cou.(Software Development)",
						"Cert. Cou.(Survey)": "Cert. Cou.(Survey)",
						"Cert. Cou.(Tour & Travel)": "Cert. Cou.(Tour & Travel)",
						"Cert. Cou.(Trade Union)": "Cert. Cou.(Trade Union)",
						"Cert. Cou.(Turner)": "Cert. Cou.(Turner)",
						"Cert. Cou.(Typing)": "Cert. Cou.(Typing)",
						"Cert. Cou.(Web Designing)": "Cert. Cou.(Web Designing)",
						"Cert. Cou.(Welding)": "Cert. Cou.(Welding)",
						"Cert. Cou.(Wireman)": "Cert. Cou.(Wireman)",
						"Statistics & Computer": "Statistics & Computer",
						"Certificate Course (Nursing)": "Certificate Course (Nursing)"
					},
					"High school": {
						"High school Certificate": "High school Certificate"
					},
					"Professional school": {
						"Professional school Certificate": "Professional school Certificate"
					},
					"Sec.profess.school": {
						"Sec.profess.school Certificate": "Sec.profess.school Certificate"
					},
					"Technical school": {
						"Technical school Certificate": "Technical school Certificate"
					},
					"Trade school": {
						"Trade school Certificate": "Trade school Certificate"
					},
					"Commercial college": {
						"Commercial college Certificate": "Commercial college Certificate"
					},
					"Higher tech. college": {
						"Higher tech. college Certificate": "Higher tech. college Certificate"
					},
					"Higher sec. school": {
						"Higher sec. school Certificate": "Higher sec. school Certificate"
					},
					"University": {
						"University Certificate": "University Certificate"
					},
					"University/college": {
						"University/college Certificate": "University/college Certificate"
					},
					"Technical school": {
						"Technical school Certificate": "Technical school Certificate"
					},
					"Language school": {
						"Language school Certificate": "Language school Certificate"
					},
					"Internal course/sem.": {
						"Internal course/sem. Certificate": "Internal course/sem. Certificate"
					},
					"External course/sem.": {
						"External course/sem. Certificate": "External course/sem. Certificate"
					}
				};
				
				// save the selected option that is passed to the function
				selection = grad.options[grad.selectedIndex].value;
				
				// get our target select box by the id that is passed into the function
				target = document.getElementById(target_id);
				
				// reset our current target options
				target.options.length = 0;
				
				// make sure the selection isn't none
				if(selection !== '') {
					// get our available options
					options = cert[selection];
					
					// assign the city and value for each option available
					for(var city in options) {
						target.options[i] = new Option(city, options[city]);
						i++;
					}
				}
			}
    
    
    
    
		</script>

@endsection

@section('bodycontent')
<body class="hold-transition skin-red fixed sidebar-mini">

<!-- Site wrapper -->
<div class="wrapper">

@foreach($getemployeedata as $employee)


 
  @include('newemployeezone.header.index')
  @include('newemployeezone.aside.index')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
   
    <!-- Main content -->
    <section class="content">
	
	<div class="row">
		<div class="col-md-10 col-md-offset-1">

	@include('newemployeezone.contenttop')


      	</div>
	</div>



	<div class="row">
		
    <div class="col-md-10 col-md-offset-1">
      
      <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-edit margin-r-5"></i>Job Application </h3><span class="pull-right" ><a href="{{ url('/employeezone/empreferfriend') }}" class="btn btn-danger btn-xs">Back</a></span>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              
               <div class="col-sm-6 col-sm-offset-3">
				 @if(session()->has('error_msg'))
				        <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                {{Session::get('error_msg')}}
              </div>
				        <br>
				 @endif
                 @if(session()->has('suc_msg'))
				        
				        <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i> Alert!</h4>
                {{Session::get('suc_msg')}}
              </div>
				        <br>
				 @endif
              </div>
               
               @foreach($getcareer as $career)
                
                <div class="col-md-5">
                
                <?php
                    for($i=1; $i<=50; $i++){
                        
                        if(!empty($career["LINE$i"])){
                        $car = str_replace('....','<br><br>',$career["LINE$i"]);
                           echo str_replace('..','<br>',$car);
                        }
                    }
                    ?>
                
                </div>
                
                <div class="col-md-7">
                
                <form id="changedetailsForm" method="POST" action="{{ url('/employeezone/empreferfriendapplyjob') }}/{{$career['JOB_CODE']}}" class="form-horizontal" enctype="multipart/form-data">
                {{ csrf_field() }}
                   <div class="row" style="margin-left:3px;">
                       <div class="col-md-12">
                           <h4 class="text-red"> <i class="fa fa-user margin-r-5"></i>  Personal Info </h4>
                            <input type="hidden" name="designation" value="{{$career['DESIGNATION']}}">
                            <input type="hidden" name="department" value="{{$career['DEPARTMENT']}}">
											<div class="form-group">
												<label for="title" class="col-sm-3">Title*</label>
												
													<div class="col-sm-8">
														
													<select class="form-control" name="title" id="tit" >
																<option value="">select</option>
																<option value="Mr" "@if(old('title') == 'Mr') selected=selected @endif">Mr</option>
																<option value="Mrs" "@if(old('title') == 'Mrs') selected=selected @endif">Mrs</option>
																<option value="Miss" "@if(old('title') == 'Miss') selected=selected @endif">Miss</option>
															</select>
													{!! $errors->first('title', '<span class="errortext text-red">:message</span>') !!}
													</div>									
												
											</div>
											<div class="form-group">
												<label for="firstname" class="col-sm-3 ">First Name*</label>
												<div class="col-sm-8">
													<input type="text" class="form-control" placeholder="First Name" value="{{ old('firstname') }}" name="firstname" id="firstname"  >
													{!! $errors->first('firstname', '<span class="errortext text-red">:message</span>') !!}
												</div>
											</div>
											<div class="form-group">
												<label for="lastname" class="col-sm-3 ">Last Name*</label>
												<div class="col-sm-8">
													<input type="text" class="form-control" placeholder="Last Name" value="{{ old('lastname') }}" name="lastname" id="lastname" >
													{!! $errors->first('lastname', '<span class="errortext text-red">:message</span>') !!}
												</div>
											</div>
                                            <div class="form-group">
                <label for="dob" class="col-sm-3 ">Date of Birth*</label>
                <div class="col-sm-8">
                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right" value="{{ old('date_of_birth') }}" name="date_of_birth" id="datepicker">
                </div>
                {!! $errors->first('date_of_birth', '<span class="errortext text-red">:message</span>') !!}
                </div>
                <!-- /.input group -->
              </div>
                                                                                    
                                            <div class="form-group">
                                            <label for="gender" class="col-sm-3 ">Gender*</label>
                                            <div class="col-sm-8">
                                      <div class="radio">
                                        <label>
                                          <input type="radio" name="gender" id="gender1" value="Male" "@if(old('gender') == 'Male') checked=true @endif">
                                         Male
                                        </label>&nbsp;
                                        <label>
                                          <input type="radio" name="gender" id="gender1" value="Female" "@if(old('gender') == 'Female') checked=true @endif">
                                         Female
                                        </label>
                                      </div>
                                      {!! $errors->first('gender', '<span class="errortext text-red">:message</span>') !!}
                                      
                                                </div>
                  
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="marital_status" class="col-sm-3 ">Marital Status*</label>
                                            <div class="col-sm-8">
                                      <div class="radio">
                                        <label>
                                          <input type="radio" name="marital_status" id="maritalstatus1" value="Single" "@if(old('marital_status') == 'Single') checked=true @endif">
                                         Single
                                        </label>&nbsp;
                                        <label>
                                          <input type="radio" name="marital_status" id="maritalstatus2" value="Marr." "@if(old('marital_status') == 'Marr.') checked=true @endif">
                                         Married
                                        </label>
                                      </div>
                                      {!! $errors->first('marital_status', '<span class="errortext text-red">:message</span>') !!}
                                      
                                                </div>
                  
                                        </div>
                                        
                                        <div class="form-group">
														<label for="inputPassword3" class="col-sm-3">Nationality*</label>
														<div class="col-sm-8">
															<select class="form-control userdropdown" name="nationality" id="nationality" >
																<option value="">select</option>
																
																<option value="Indian" "@if(old('nationality') == 'Indian') selected=selected @endif">Indian</option>
																
															</select>
															 {!! $errors->first('nationality', '<span class="errortext text-red">:message</span>') !!}
														</div>
													</div>
													<div class="form-group">
														<label for="language" class="col-sm-3">Languages Known*</label>
														<div class="col-sm-8">
															<input type="text" class="form-control userdropdown" name="language" id="lang" placeholder="Languages Known">
															{!! $errors->first('language', '<span class="errortext text-red">:message</span>') !!}
														</div>
													</div>
																						
											
											<h4 class="text-red"><i class="fa fa-map-marker margin-r-5"></i>  Permanent Address</h4>
											<div class="form-group">
												<label for="house_and_street_no" class="col-sm-3 ">House No. and Street*</label>
												<div class="col-sm-8">
													<input type="text" class="form-control" placeholder="House No. and Street" value="{{ old('house_and_street_no') }}" name="house_and_street_no" id="house_and_street_no"  >
													{!! $errors->first('house_and_street_no', '<span class="errortext text-red">:message</span>') !!}
												</div>
											</div>
											<div class="form-group">
												<label for="second_address_line" class="col-sm-3 ">2nd address line</label>
												<div class="col-sm-8">
													<input type="text" class="form-control" placeholder="2nd address line" value="{{ old('second_address_line') }}" name="second_address_line" id="second_address_line">
													{!! $errors->first('second_address_line', '<span class="errortext text-red">:message</span>') !!}
												</div>
											</div>
											<div class="form-group">
												<label for="city" class="col-sm-3 ">City*</label>
												<div class="col-sm-8">
													<input type="text" class="form-control" placeholder="City" value="{{ old('city') }}" name="city" id="city"  >
													{!! $errors->first('city', '<span class="errortext text-red">:message</span>') !!}
												</div>
											</div>
											<div class="form-group">
												<label for="district" class="col-sm-3 ">District</label>
												<div class="col-sm-8">
													<input type="text" class="form-control" placeholder="District" value="{{ old('district') }}" name="district" id="district"  >
													{!! $errors->first('district', '<span class="errortext text-red">:message</span>') !!}
												</div>
											</div>
											
											<div class="form-group">
														<label for="country" class="col-sm-3">Country*</label>
														<div class="col-sm-8">
															<select class="form-control userdropdown" name="country" id="country" >
																<option  value="">select</option>
																
																<option value="India" selected>India</option>
																
															</select>
															{!! $errors->first('country', '<span class="errortext text-red">:message</span>') !!}
														</div>
													</div>
													<div class="form-group">
														<label for="region" class="col-sm-3">Region</label>
														<div class="col-sm-8">
															<select class="form-control userdropdown" name="region" id="region">
																<option value="">Select</option>
																
																<option value="Andhra Pradesh" "@if(old('region') == 'Andhra Pradesh') selected=selected @endif">Andhra Pradesh</option><option value="Arunachal Pradesh" "@if(old('region') == 'Arunachal Pradesh') selected=selected @endif">Arunachal Pradesh</option><option value="Assam" "@if(old('region') == 'Assam') selected=selected @endif">Assam</option><option value="Bihar" "@if(old('region') == 'Bihar') selected=selected @endif">Bihar</option><option value="Goa" "@if(old('region') == 'Goa') selected=selected @endif">Goa</option><option value="Chennai" "@if(old('region') == 'Chennai') selected=selected @endif">Chennai</option><option value="Gujarat" "@if(old('region') == 'Gujarat') selected=selected @endif">Gujarat</option><option value="Haryana" "@if(old('region') == 'Haryana') selected=selected @endif">Haryana</option><option value="Himachal Pradesh" "@if(old('region') == 'Himachal Pradesh') selected=selected @endif">Himachal Pradesh</option><option value="Jammu and Kashmir" "@if(old('region') == 'Jammu and Kashmir') selected=selected @endif">Jammu and Kashmir</option><option value="Karnataka" "@if(old('region') == 'Karnataka') selected=selected @endif">Karnataka</option><option value="Kerala" "@if(old('region') == 'Kerala') selected=selected @endif">Kerala</option><option value="Madhya Pradesh" "@if(old('region') == 'Madhya Pradesh') selected=selected @endif">Madhya Pradesh</option><option value="Maharashtra" "@if(old('region') == 'Maharashtra') selected=selected @endif">Maharashtra</option><option value="Manipur" "@if(old('region') == 'Manipur') selected=selected @endif">Manipur</option><option value="Megalaya" "@if(old('region') == 'Megalaya') selected=selected @endif">Megalaya</option><option value="Mizoram" "@if(old('region') == 'Mizoram') selected=selected @endif">Mizoram</option><option value="Nagaland" "@if(old('region') == 'Nagaland') selected=selected @endif">Nagaland</option><option value="Orissa" "@if(old('region') == 'Orissa') selected=selected @endif">Orissa</option><option value="Punjab" "@if(old('region') == 'Punjab') selected=selected @endif">Punjab</option><option value="Rajasthan" "@if(old('region') == 'Rajasthan') selected=selected @endif">Rajasthan</option><option value="Sikkim" "@if(old('region') == 'Sikkim') selected=selected @endif">Sikkim</option><option value="Tamil Nadu" "@if(old('region') == 'Tamil Nadu') selected=selected @endif">Tamil Nadu</option><option value="Tripura" "@if(old('region') == 'Tripura') selected=selected @endif">Tripura</option><option value="Uttar Pradesh" "@if(old('region') == 'Uttar Pradesh') selected=selected @endif">Uttar Pradesh</option>
																<option value="West Bengal" "@if(old('region') == 'West Bengal') selected=selected @endif">West Bengal</option><option value="Andaman und Nico.In." "@if(old('region') == 'Andaman und Nico.In.') selected=selected @endif">Andaman und Nico.In.</option><option value="Chandigarh" "@if(old('region') == 'Chandigarh') selected=selected @endif">Chandigarh</option><option value="Dadra und Nagar Hav." "@if(old('region') == 'Dadra und Nagar Hav.') selected=selected @endif">Dadra und Nagar Hav.</option><option value="Daman and Diu" "@if(old('region') == 'Daman and Diu') selected=selected @endif">Daman and Diu</option><option value="Delhi" "@if(old('region') == 'Delhi') selected=selected @endif">Delhi</option><option value="Lakshadweep" "@if(old('region') == 'Lakshadweep') selected=selected @endif">Lakshadweep</option><option value="Pondicherry" "@if(old('region') == 'Pondicherry') selected=selected @endif">Pondicherry</option><option value="Chhaattisgarh" "@if(old('region') == 'Chhaattisgarh') selected=selected @endif">Chhaattisgarh</option><option value="Jharkhand" "@if(old('region') == 'Jharkhand') selected=selected @endif">Jharkhand</option><option value="Uttaranchal" "@if(old('region') == 'Uttaranchal') selected=selected @endif">Uttaranchal</option>
															</select>
															{!! $errors->first('region', '<span class="errortext text-red">:message</span>') !!}
														</div>
													</div>
													<div class="form-group">
														<label for="postalcode" class="col-sm-3">Postal Code*</label>
														<div class="col-sm-8">
															<input type="text" class="form-control" name="postalcode" id="postalcode" placeholder="postal code" value="{{old('postalcode')}}" onkeypress="return isNumberKey(this)" >
															{!! $errors->first('postalcode', '<span class="errortext text-red">:message</span>') !!} 
														</div>
													</div>
													
													<h4 class="text-red"><i class="fa fa-user margin-r-5"></i>  Contact Details</h4>
													
													<div class="form-group">
														<label for="mobile" class="col-sm-3">Mobile Number*</label>
														<div class="col-sm-8">
															<input type="text" class="form-control" name="mobile" id="tel" placeholder="Mobile Number" minlength="10" maxlength="14" onkeypress="return isNumberKey(this)" value="{{old('mobile')}}" >
															{!! $errors->first('mobile', '<span class="errortext text-red">:message</span>') !!} 
														</div>
													</div>
													<div class="form-group">
														<label for="mailid" class="col-sm-3">E-Mail ID*</label>
														<div class="col-sm-8">
															<input type="email" class="form-control" name="email_id" id="mailid" maxlength="241" placeholder="E-Mail ID" value="{{old('email_id')}}" >
															{!! $errors->first('email_id', '<span class="errortext text-red">:message</span>') !!} 
														</div>
													</div>
													<h4 class="text-red"><i class="fa fa-graduation-cap margin-r-5"></i>  Education</h4>
													
													<div class="form-group">
														<label for="from_to_date" class="col-sm-3">From / To Date</label>
														<div class="col-sm-4">
													<div class="input-group date">
                          <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                          </div>
															<input type="text" class="form-control pull-right" name="education_from_date" id="datepicker_to_from_date" value="{{old('education_from_date')}}" >
                                                    </div>
                                                    {!! $errors->first('education_from_date', '<span class="errortext text-red">:message</span>') !!} 
														</div>
														<div class="col-sm-4">
												<div class="input-group date">
                          <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                          </div>
								<input type="text" class="form-control" name="education_to_date" id="education_to_date" value="{{old('education_to_date')}}" > 
                                                            </div>
                                                            {!! $errors->first('education_to_date', '<span class="errortext text-red">:message</span>') !!} 
														</div>
													</div>
													<div class="form-group">
														<label for="graduation" class="col-sm-3">Type of Graduation</label>
														<div class="col-sm-8">
															<select class="form-control userdropdown" name="graduation" id="graduation">
																<option value="">select</option>
																<option value="Non-SSC" "@if(old('graduation') == 'Non-SSC') selected=selected @endif">Non-SSC</option>
																<option value="SSC" "@if(old('graduation') == 'SSC') selected=selected @endif">SSC	</option>
																<option value="ITI" "@if(old('graduation') == 'ITI') selected=selected @endif">ITI	</option>
																<option value="HSC" "@if(old('graduation') == 'HSC') selected=selected @endif">HSC	</option>
																<option value="Diploma" "@if(old('graduation') == 'Diploma') selected=selected @endif">Diploma	</option>
																<option value="Graduate" "@if(old('graduation') == 'Graduate') selected=selected @endif">Graduate	</option>
																<option value="Post Graduate" "@if(old('graduation') == 'Post Graduate') selected=selected @endif">Post Graduate	</option>
																<option value="Certificate Course" "@if(old('graduation') == 'Certificate Course') selected=selected @endif">Certificate Course</option>	
																<option value="Junior high school" "@if(old('graduation') == 'Junior high school') selected=selected @endif">Junior high school</option>	
																<option value="High school" "@if(old('graduation') == 'High school') selected=selected @endif">High school	</option>
																<option value="Professional school" "@if(old('graduation') == 'Professional school') selected=selected @endif">Professional school	</option>
																<option value="Sec.profess.school" "@if(old('graduation') == 'Sec.profess.school') selected=selected @endif">Sec.profess.school</option>
																<option value="Technical school" "@if(old('graduation') == 'Technical school') selected=selected @endif">Technical school	</option>
																<option value="Trade school" "@if(old('graduation') == 'Trade school') selected=selected @endif">Trade school	</option>
																<option value="Commercial college" "@if(old('graduation') == 'Commercial college') selected=selected @endif">Commercial college	</option>
																<option value="Higher tech. college" "@if(old('graduation') == 'Higher tech. college') selected=selected @endif">Higher tech. college	</option>
																<option value="Higher sec. school" "@if(old('graduation') == 'Higher sec. school') selected=selected @endif">Higher sec. school	</option>
																<option value="University" "@if(old('graduation') == 'University') selected=selected @endif">University	</option>
																<option value="University/college" "@if(old('graduation') == 'University/college') selected=selected @endif">University/college	</option>
																<option value="Technical school" "@if(old('graduation') == 'Technical school') selected=selected @endif">Technical school	</option>
																<option value="Language school" "@if(old('graduation') == 'Language school') selected=selected @endif">Language school	</option>
																<option value="Internal course/sem." "@if(old('graduation') == 'Internal course/sem.') selected=selected @endif">Internal course/sem.	</option>
																<option value="External course/sem." "@if(old('graduation') == 'External course/sem.') selected=selected @endif">External course/sem.	</option>
															</select>
															{!! $errors->first('graduation', '<span class="errortext text-red">:message</span>') !!}
														</div>
													</div>
													<div class="form-group">
														<label for="certificate" class="col-sm-3">Certificate</label>
														<div class="col-sm-8">
															<select class="form-control userdropdown" name="certificate" id="certificate" >
																<option value="">select</option>
															</select>
															{!! $errors->first('certificate', '<span class="errortext text-red">:message</span>') !!}
														</div>
													</div>
													<div class="form-group">
														<label for="institute" class="col-sm-3">Institute</label>
														<div class="col-sm-8">
															<input type="text" class="form-control" name="institute" id="inst" placeholder="Institute" maxlength="80" onkeypress="return checkNum()" value="{{old('institute')}}" >
															{!! $errors->first('institute', '<span class="errortext text-red">:message</span>') !!}
														</div>
													</div>
													<div class="form-group">
														<label for="education_country" class="col-sm-3">Country</label>
														<div class="col-sm-8">
															<select class="form-control userdropdown" name="education_country" id="education_country" >
																<option value="">select</option>
																<option value="Andorran">Andorran</option>
																<option value="Utd.Arab Emir.">Utd.Arab Emir.</option>
																<option value="Afghanistan">Afghanistan</option>
																<option value="Antigua/Barbuda">Antigua/Barbuda</option>
																<option value="Anguilla">Anguilla</option>
																<option value="Albania">Albania</option>
																<option value="Armenia">Armenia</option>
																<option value="Dutch Antilles">Dutch Antilles</option>
																<option value="Angola">Angola</option>
																<option value="Antarctica">Antarctica</option>
																<option value="Argentina">Argentina</option>
																<option value="Samoa, America">Samoa, America</option>
																<option value="Austria">Austria</option>
																<option value="Australia">Australia</option>
																<option value="Aruba">Aruba</option>
																<option value="Azerbaijan">Azerbaijan</option>
																<option value="Bosnia-Herz.">Bosnia-Herz.</option>
																<option value="Barbados">Barbados</option>
																<option value="Bangladesh">Bangladesh</option>
																<option value="Belgium">Belgium</option>
																<option value="Burkina Faso">Burkina Faso</option>
																<option value="Bulgaria">Bulgaria</option>
																<option value="Bahrain">Bahrain</option>
																<option value="Burundi">Burundi</option>
																<option value="Benin">Benin</option>
																<option value="Blue">Blue</option>
																<option value="Bermuda">Bermuda</option>
																<option value="Brunei Daruss.">Brunei Daruss.</option>
																<option value="Bolivia">Bolivia</option>
																<option value="Brazil">Brazil</option>
																<option value="Bahamas">Bahamas</option>
																<option value="Bhutan">Bhutan</option>
																<option value="Bouvet Islands">Bouvet Islands</option>
																<option value="Botswana">Botswana</option>
																<option value="Belarus">Belarus</option>
																<option value="Belize">Belize</option>
																<option value="Canada">Canada</option>
																<option value="Coconut Islands">Coconut Islands</option>
																<option value="Dem. Rep. Congo">Dem. Rep. Congo</option>
																<option value="CAR">CAR</option>
																<option value="Rep.of Congo">Rep.of Congo</option>
																<option value="Switzerland">Switzerland</option>
																<option value="Cote d'Ivoire">Cote d'Ivoire</option>
																<option value="Cook Islands">Cook Islands</option>
																<option value="Chile">Chile</option>
																<option value="Cameroon">Cameroon</option>
																<option value="China">China</option>
																<option value="Colombia">Colombia</option>
																<option value="Costa Rica">Costa Rica</option>
																<option value="Serbia/Monten.">Serbia/Monten.</option>
																<option value="Cuba">Cuba</option>
																<option value="Cape Verde">Cape Verde</option>
																<option value="Christmas Islnd">Christmas Islnd</option>
																<option value="Cyprus">Cyprus</option>
																<option value="Czech Republic">Czech Republic</option>
																<option value="Germany">Germany</option>
																<option value="Djibouti">Djibouti</option>
																<option value="Denmark">Denmark</option>
																<option value="Dominica">Dominica</option>
																<option value="Dominican Rep.">Dominican Rep.</option>
																<option value="lgeria">lgeria</option>
																<option value="Ecuador">Ecuador</option>
																<option value="Estonia">Estonia</option>
																<option value="Egypt">Egypt</option>
																<option value="West Sahara">West Sahara</option>
																<option value="Eritrea">Eritrea</option>
																<option value="Spain">Spain</option>
																<option value="Ethiopia">Ethiopia</option>
																<option value="European Union">European Union</option>
																<option value="Finland">Finland</option>
																<option value="Fiji">Fiji</option>
																<option value="Falkland Islnds">Falkland Islnds</option>
																<option value="Micronesia">Micronesia</option>
																<option value="Faroe Islands">Faroe Islands</option>
																<option value="France">France</option>
																<option value="Gabon">Gabon</option>
																<option value="United Kingdom">United Kingdom</option>
																<option value="Grenada">Grenada</option>
																<option value="Georgia">Georgia</option>
																<option value="French Guayana">French Guayana</option>
																<option value="Ghana">Ghana</option>
																<option value="Gibraltar">Gibraltar</option>
																<option value="Greenland">Greenland</option>
																<option value="Gambia">Gambia</option>
																<option value="Guinea">Guinea</option>
																<option value="Guadeloupe">Guadeloupe</option>
																<option value="Equatorial Guin">Equatorial Guin</option>
																<option value="Greece">Greece</option>
																<option value="S. Sandwich Ins">S. Sandwich Ins</option>
																<option value="Guatemala">Guatemala</option>
																<option value="Guam">Guam</option>
																<option value="Guinea-Bissau">Guinea-Bissau</option>
																<option value="Guyana">Guyana</option>
																<option value="Hong Kong">Hong Kong</option>
																<option value="Heard/McDon.Isl">Heard/McDon.Isl</option>
																<option value="Honduras">Honduras</option>
																<option value="Croatia">Croatia</option>
																<option value="Haiti">Haiti</option>
																<option value="Hungary">Hungary</option>
																<option value="Indonesia">Indonesia</option>
																<option value="Ireland">Ireland</option>
																<option value="Israel">Israel</option>
																<option value="India">India</option>
																<option value="Brit.Ind.Oc.Ter">Brit.Ind.Oc.Ter</option>
																<option value="Iraq">Iraq</option>
																<option value="Iran">Iran</option>
																<option value="Iceland">Iceland</option>
																<option value="Italy">Italy</option>
																<option value="Jamaica">Jamaica</option>
																<option value="Jordan">Jordan</option>
																<option value="Japan">Japan</option>
																<option value="Kenya">Kenya</option>
																<option value="Kyrgyzstan">Kyrgyzstan</option>
																<option value="Cambodia">Cambodia</option>
																<option value="Kiribati">Kiribati</option>
																<option value="Comoros">Comoros</option>
																<option value="St Kitts&Nevis">St Kitts&Nevis </option>
																<option value="North Korea">North Korea</option>
																<option value="South Korea">South Korea</option>
																<option value="Kuwait">Kuwait</option>
																<option value="Cayman Islands">Cayman Islands</option>
																<option value="Kazakhstan">Kazakhstan</option>
																<option value="Laos">Laos</option>
																<option value="Lebanon">Lebanon</option>
																<option value="St. Lucia">St. Lucia</option>
																<option value="Liechtenstein">Liechtenstein</option>
																<option value="Sri Lanka">Sri Lanka</option>
																<option value="Liberia">Liberia</option>
																<option value="Lesotho">Lesotho</option>
																<option value="Lithuania">Lithuania</option>
																<option value="Luxembourg">Luxembourg</option>
																<option value="Latvia">Latvia</option>
																<option value="Libya">Libya</option>
																<option value="Morocco">Morocco</option>
																<option value="Monaco">Monaco</option>
																<option value="Moldova">Moldova</option>
																<option value="Madagascar">Madagascar</option>
																<option value="Marshall Islnds">Marshall Islnds</option>
																<option value="Macedonia">Macedonia</option>
																<option value="Mali">Mali</option>
																<option value="Burma">Burma</option>
																<option value="Mongolia">Mongolia</option>
																<option value="Macau">Macau</option>
																<option value="N.Mariana Islnd">N.Mariana Islnd</option>
																<option value="Martinique">Martinique</option>
																<option value="Mauretania">Mauretania</option>
																<option value="Montserrat">Montserrat</option>
																<option value="Malta">Malta</option>
																<option value="Mauritius">Mauritius</option>
																<option value="Maldives">Maldives</option>
																<option value="Malawi">Malawi</option>
																<option value="Mexico">Mexico</option>
																<option value="Malaysia">Malaysia</option>
																<option value="Mozambique">Mozambique</option>
																<option value="Namibia">Namibia</option>
																<option value="New Caledonia">New Caledonia</option>
																<option value="Niger">Niger</option>
																<option value="Norfolk Islands">Norfolk Islands</option>
																<option value="Nigeria">Nigeria</option>
																<option value="Nicaragua">Nicaragua</option>
																<option value="Netherlands">Netherlands</option>
																<option value="Norway">Norway</option>
																<option value="Nepal">Nepal</option>
																<option value="Nauru">Nauru</option>
																<option value="NATO">NATO</option>
																<option value="Niue">Niue</option>
																<option value="New Zealand">New Zealand</option>
																<option value="Oman">Oman</option>
																<option value="Orange">Orange</option>
																<option value="Panama">Panama</option>
																<option value="Peru">Peru</option>
																<option value="Frenc.Polynesia">Frenc.Polynesia</option>
																<option value="Pap. New Guinea">Pap. New Guinea</option>
																<option value="Philippines">Philippines</option>
																<option value="Pakistan">Pakistan</option>
																<option value="Poland">Poland</option>
																<option value="St.Pier,Miquel.">St.Pier,Miquel.</option>
																<option value="Pitcairn Islnds">Pitcairn Islnds</option>
																<option value="Puerto Rico">Puerto Rico</option>
																<option value="Palestine">Palestine</option>
																<option value="Portugal">Portugal</option>
																<option value="Palau">Palau</option>
																<option value="Paraguay">Paraguay</option>
																<option value="Qatar">Qatar</option>
																<option value="Reunion">Reunion</option>
																<option value="Romania">Romania</option>
																<option value="Russian Fed.">Russian Fed.</option>
																<option value="Rwanda">Rwanda</option>
																<option value="Saudi Arabia">Saudi Arabia</option>
																<option value="Solomon Islands">Solomon Islands</option>
																<option value="Seychelles">Seychelles</option>
																<option value="Sudan">Sudan</option>
																<option value="Sweden">Sweden</option>
																<option value="Singapore">Singapore</option>
																<option value="Saint Helena">Saint Helena</option>
																<option value="Slovenia">Slovenia</option>
																<option value="Svalbard">Svalbard</option>
																<option value="Slovakia">Slovakia</option>
																<option value="Sierra Leone">Sierra Leone</option>
																<option value="San Marino">San Marino</option>
																<option value="Senegal">Senegal</option>
																<option value="Somalia">Somalia</option>
																<option value="Suriname">Suriname</option>
																<option value="S.Tome,Principe">S.Tome,Principe</option>
																<option value="El Salvador">El Salvador</option>
																<option value="Syria">Syria</option>
																<option value="Swaziland">Swaziland</option>
																<option value="Turksh Caicosin">Turksh Caicosin</option>
																<option value="Chad">Chad</option>
																<option value="French S.Territ">French S.Territ</option>
																<option value="Togo">Togo</option>
																<option value="Thailand">Thailand</option>
																<option value="Tajikistan">Tajikistan</option>
																<option value="Tokelau Islands">Tokelau Islands</option>
																<option value="East Timor">East Timor</option>
																<option value="Turkmenistan">Turkmenistan</option>
																<option value="Tunisia">Tunisia</option>
																<option value="Tonga">Tonga</option>
																<option value="East Timor">East Timor</option>
																<option value="Turkey">Turkey</option>
																<option value="Trinidad,Tobago">Trinidad,Tobago</option>
																<option value="Tuvalu">Tuvalu</option>
																<option value="Taiwan">Taiwan</option>
																<option value="Tanzania">Tanzania</option>
																<option value="Ukraine">Ukraine</option>
																<option value="Uganda">Uganda</option>
																<option value="Minor Outl.Isl.">Minor Outl.Isl.</option>
																<option value="United Nations">United Nations</option>
																<option value="USA">USA</option>
																<option value="Uruguay">Uruguay</option>
																<option value="Uzbekistan">Uzbekistan</option>
																<option value="Vatican City">Vatican City</option>
																<option value="St. Vincent">St. Vincent</option>
																<option value="Venezuela">Venezuela</option>
																<option value="Brit.Virgin Is.">Brit.Virgin Is.</option>
																<option value="Amer.Virgin Is.">Amer.Virgin Is.</option>
																<option value="Vietnam">Vietnam</option>
																<option value="Vanuatu">Vanuatu</option>
																<option value="Wallis,Futuna">Wallis,Futuna</option>
																<option value="Samoa">Samoa</option>
																<option value="Yemen">Yemen</option>
																<option value="Mayotte">Mayotte</option>
																<option value="South Africa">South Africa</option>
																<option value="Zambia">Zambia</option>
																<option value="Zimbabwe">Zimbabwe</option>
															</select>
															{!! $errors->first('education_country', '<span class="errortext text-red">:message</span>') !!}
														</div>
													</div>
													<div class="form-group">
														<label for="mark" class="col-sm-3">Marks (in percentage)</label>
														<div class="col-sm-8">
															<input type="text" class="form-control" name="mark" id="mark" placeholder="Marks" minlength="2" maxlength="3" onkeypress="return isNumberKey(this)" value="{{old('mark')}}" >
															{!! $errors->first('mark', '<span class="errortext text-red">:message</span>') !!}
														</div>
													</div>
												</div>
												
													
													<h4 class="text-red"><i class="fa fa-undo margin-r-5"></i> Previous Experience</h4>
													
													<div class="form-group">
														<label for="inputPassword3" class="col-sm-3">Last Employement From / To Date</label>
														<div class="col-sm-4">
														<div class="input-group date">
                          <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                          </div>
															<input type="text" class="form-control prev_exp datepicker" name="previous_experience_from_date" id="expr_from_date" value="{{old('previous_experience_from_date')}}" >
                                                            </div>
                                                            {!! $errors->first('previous_experience_from_date', '<span class="errortext text-red">:message</span>') !!}
														</div>
														<div class="col-sm-4">
														<div class="input-group date">
                          <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                          </div>
															<input type="text" class="form-control prev_exp datepicker" name="previous_experience_to_date" id="expr_to_date" value="{{old('previous_experience_to_date')}}" >
                                                            </div>
                                                            {!! $errors->first('previous_experience_to_date', '<span class="errortext text-red">:message</span>') !!}
														</div>
													</div>
													<div class="form-group">
														<label for="employer_name" class="col-sm-3">Name of Last Employer</label>
														<div class="col-sm-8">
															<input type="text" class="form-control prev_exp" name="employer_name" id="emp_name" placeholder="Name of Employer" maxlength="60" onkeypress="return checkNum()" value="{{old('employer_name')}}">
															{!! $errors->first('employer_name', '<span class="errortext text-red">:message</span>') !!}
														</div>
													</div>
													<div class="form-group">
														<label for="industry" class="col-sm-3">Industry</label>
														<div class="col-sm-8">
															<select class="form-control prev_exp userdropdown" name="industry" id="indst">
																<option value="">select</option>
																<option value="Aerospace">Aerospace</option>
																<option value="Agriculture Sector">Agriculture Sector</option>	
																<option value="Aircraft">Aircraft</option>	
																<option value="Airline">Airline	</option>
																<option value="Alcohol & Narcotics">Alcohol & Narcotics</option>	
																<option value="Aluminum">Aluminum	</option>
																<option value="Automobile">Automobile	</option>
																<option value="Banking">Banking	</option>
																<option value="Bus Transportation">Bus Transportation	</option>
																<option value="Coal">Coal	</option>
																<option value="Chemicals">Chemicals	</option>
																<option value="Computer Hardware">Computer Hardware</option>	
																<option value="Computer">Computer	</option>
																<option value="Construction">Construction	</option>
																<option value="Dairy">Dairy	</option>
																<option value="Elex & Elec. Equipt.">Elex & Elec. Equipt.	</option>
																<option value="Energy Sector">Energy Sector	</option>
																<option value="Entertainment">Entertainment	</option>
																<option value="Engineering">Engineering	</option>
																<option value="Fashion">Fashion	</option>
																<option value="Film">Film	</option>
																<option value="Financial">Financial	</option>
																<option value="Food and Beverage">Food and Beverage	</option>
																<option value="Healthcare">Healthcare	</option>
																<option value="Hospital">Hospital	</option>
																<option value="Hospitality">Hospitality	</option>
																<option value="Housing">Housing	</option>
																<option value="Industrial Sector">Industrial Sector	</option>
																<option value="Infrastructure">Infrastructure	</option>
																<option value="Manufacturing Sector">Manufacturing Sector	</option>
																<option value="Maritime">Maritime	</option>
																<option value="Meat Packing">Meat Packing	</option>
																<option value="Metallurgy">Metallurgy	</option>
																<option value="Mortgage">Mortgage	</option>
																<option value="Natron">Natron	</option>
																<option value="Natural Gas">Natural Gas	</option>
																<option value="Nuclear">Nuclear	</option>
																<option value="Offshore Banking">Offshore Banking	</option>
																<option value="Oil">Oil	</option>
																<option value="Printing">Printing	</option>
																<option value="Publishing">Publishing	</option>
																<option value="Sales Eco. Sector">Sales Eco. Sector	</option>
																<option value="Services Sector">Services Sector	</option>
																<option value="Shipbuilding">Shipbuilding	</option>
																<option value="Ship repairing">Ship repairing	</option>
																<option value="Smelting">Smelting	</option>
																<option value="Software">Software	</option>
																<option value="Steel">Steel	</option>
																<option value="Technology">Technology	</option>
																<option value="Telecommunications">Telecommunications	</option>
																<option value="The wine">The wine	</option>
																<option value="Tourism">Tourism	</option>
																<option value="Transportation">Transportation	</option>
																<option value="Wireless Telecomm.">Wireless Telecomm.	</option>
																
															</select>
															{!! $errors->first('industry', '<span class="errortext text-red">:message</span>') !!}
														</div>
													</div>
													<div class="form-group">
														<label for="employer_city" class="col-sm-3">City</label>
														<div class="col-sm-8">
															<input type="text" class="form-control prev_exp" name="employer_city" id="emp_city" placeholder="City" maxlength="25" onkeypress="return checkNum()" value="{{old('employer_city')}}"> 
															{!! $errors->first('employer_city', '<span class="errortext text-red">:message</span>') !!}
														</div>
													</div>
													<div class="form-group">
														<label for="employer_country" class="col-sm-3">Country</label>
														<div class="col-sm-8">
															<select class="form-control prev_exp userdropdown" name="employer_country" id="employer_country">
																<option value="">select</option>
																<option value="">select</option>
																<option value="Andorran">Andorran</option>
																<option value="Utd.Arab Emir.">Utd.Arab Emir.</option>
																<option value="Afghanistan">Afghanistan</option>
																<option value="Antigua/Barbuda">Antigua/Barbuda</option>
																<option value="Anguilla">Anguilla</option>
																<option value="Albania">Albania</option>
																<option value="Armenia">Armenia</option>
																<option value="Dutch Antilles">Dutch Antilles</option>
																<option value="Angola">Angola</option>
																<option value="Antarctica">Antarctica</option>
																<option value="Argentina">Argentina</option>
																<option value="Samoa, America">Samoa, America</option>
																<option value="Austria">Austria</option>
																<option value="Australia">Australia</option>
																<option value="Aruba">Aruba</option>
																<option value="Azerbaijan">Azerbaijan</option>
																<option value="Bosnia-Herz.">Bosnia-Herz.</option>
																<option value="Barbados">Barbados</option>
																<option value="Bangladesh">Bangladesh</option>
																<option value="Belgium">Belgium</option>
																<option value="Burkina Faso">Burkina Faso</option>
																<option value="Bulgaria">Bulgaria</option>
																<option value="Bahrain">Bahrain</option>
																<option value="Burundi">Burundi</option>
																<option value="Benin">Benin</option>
																<option value="Blue">Blue</option>
																<option value="Bermuda">Bermuda</option>
																<option value="Brunei Daruss.">Brunei Daruss.</option>
																<option value="Bolivia">Bolivia</option>
																<option value="Brazil">Brazil</option>
																<option value="Bahamas">Bahamas</option>
																<option value="Bhutan">Bhutan</option>
																<option value="Bouvet Islands">Bouvet Islands</option>
																<option value="Botswana">Botswana</option>
																<option value="Belarus">Belarus</option>
																<option value="Belize">Belize</option>
																<option value="Canada">Canada</option>
																<option value="Coconut Islands">Coconut Islands</option>
																<option value="Dem. Rep. Congo">Dem. Rep. Congo</option>
																<option value="CAR">CAR</option>
																<option value="Rep.of Congo">Rep.of Congo</option>
																<option value="Switzerland">Switzerland</option>
																<option value="Cote d'Ivoire">Cote d'Ivoire</option>
																<option value="Cook Islands">Cook Islands</option>
																<option value="Chile">Chile</option>
																<option value="Cameroon">Cameroon</option>
																<option value="China">China</option>
																<option value="Colombia">Colombia</option>
																<option value="Costa Rica">Costa Rica</option>
																<option value="Serbia/Monten.">Serbia/Monten.</option>
																<option value="Cuba">Cuba</option>
																<option value="Cape Verde">Cape Verde</option>
																<option value="Christmas Islnd">Christmas Islnd</option>
																<option value="Cyprus">Cyprus</option>
																<option value="Czech Republic">Czech Republic</option>
																<option value="Germany">Germany</option>
																<option value="Djibouti">Djibouti</option>
																<option value="Denmark">Denmark</option>
																<option value="Dominica">Dominica</option>
																<option value="Dominican Rep.">Dominican Rep.</option>
																<option value="lgeria">lgeria</option>
																<option value="Ecuador">Ecuador</option>
																<option value="Estonia">Estonia</option>
																<option value="Egypt">Egypt</option>
																<option value="West Sahara">West Sahara</option>
																<option value="Eritrea">Eritrea</option>
																<option value="Spain">Spain</option>
																<option value="Ethiopia">Ethiopia</option>
																<option value="European Union">European Union</option>
																<option value="Finland">Finland</option>
																<option value="Fiji">Fiji</option>
																<option value="Falkland Islnds">Falkland Islnds</option>
																<option value="Micronesia">Micronesia</option>
																<option value="Faroe Islands">Faroe Islands</option>
																<option value="France">France</option>
																<option value="Gabon">Gabon</option>
																<option value="United Kingdom">United Kingdom</option>
																<option value="Grenada">Grenada</option>
																<option value="Georgia">Georgia</option>
																<option value="French Guayana">French Guayana</option>
																<option value="Ghana">Ghana</option>
																<option value="Gibraltar">Gibraltar</option>
																<option value="Greenland">Greenland</option>
																<option value="Gambia">Gambia</option>
																<option value="Guinea">Guinea</option>
																<option value="Guadeloupe">Guadeloupe</option>
																<option value="Equatorial Guin">Equatorial Guin</option>
																<option value="Greece">Greece</option>
																<option value="S. Sandwich Ins">S. Sandwich Ins</option>
																<option value="Guatemala">Guatemala</option>
																<option value="Guam">Guam</option>
																<option value="Guinea-Bissau">Guinea-Bissau</option>
																<option value="Guyana">Guyana</option>
																<option value="Hong Kong">Hong Kong</option>
																<option value="Heard/McDon.Isl">Heard/McDon.Isl</option>
																<option value="Honduras">Honduras</option>
																<option value="Croatia">Croatia</option>
																<option value="Haiti">Haiti</option>
																<option value="Hungary">Hungary</option>
																<option value="Indonesia">Indonesia</option>
																<option value="Ireland">Ireland</option>
																<option value="Israel">Israel</option>
																<option value="India">India</option>
																<option value="Brit.Ind.Oc.Ter">Brit.Ind.Oc.Ter</option>
																<option value="Iraq">Iraq</option>
																<option value="Iran">Iran</option>
																<option value="Iceland">Iceland</option>
																<option value="Italy">Italy</option>
																<option value="Jamaica">Jamaica</option>
																<option value="Jordan">Jordan</option>
																<option value="Japan">Japan</option>
																<option value="Kenya">Kenya</option>
																<option value="Kyrgyzstan">Kyrgyzstan</option>
																<option value="Cambodia">Cambodia</option>
																<option value="Kiribati">Kiribati</option>
																<option value="Comoros">Comoros</option>
																<option value="St Kitts&Nevis">St Kitts&Nevis </option>
																<option value="North Korea">North Korea</option>
																<option value="South Korea">South Korea</option>
																<option value="Kuwait">Kuwait</option>
																<option value="Cayman Islands">Cayman Islands</option>
																<option value="Kazakhstan">Kazakhstan</option>
																<option value="Laos">Laos</option>
																<option value="Lebanon">Lebanon</option>
																<option value="St. Lucia">St. Lucia</option>
																<option value="Liechtenstein">Liechtenstein</option>
																<option value="Sri Lanka">Sri Lanka</option>
																<option value="Liberia">Liberia</option>
																<option value="Lesotho">Lesotho</option>
																<option value="Lithuania">Lithuania</option>
																<option value="Luxembourg">Luxembourg</option>
																<option value="Latvia">Latvia</option>
																<option value="Libya">Libya</option>
																<option value="Morocco">Morocco</option>
																<option value="Monaco">Monaco</option>
																<option value="Moldova">Moldova</option>
																<option value="Madagascar">Madagascar</option>
																<option value="Marshall Islnds">Marshall Islnds</option>
																<option value="Macedonia">Macedonia</option>
																<option value="Mali">Mali</option>
																<option value="Burma">Burma</option>
																<option value="Mongolia">Mongolia</option>
																<option value="Macau">Macau</option>
																<option value="N.Mariana Islnd">N.Mariana Islnd</option>
																<option value="Martinique">Martinique</option>
																<option value="Mauretania">Mauretania</option>
																<option value="Montserrat">Montserrat</option>
																<option value="Malta">Malta</option>
																<option value="Mauritius">Mauritius</option>
																<option value="Maldives">Maldives</option>
																<option value="Malawi">Malawi</option>
																<option value="Mexico">Mexico</option>
																<option value="Malaysia">Malaysia</option>
																<option value="Mozambique">Mozambique</option>
																<option value="Namibia">Namibia</option>
																<option value="New Caledonia">New Caledonia</option>
																<option value="Niger">Niger</option>
																<option value="Norfolk Islands">Norfolk Islands</option>
																<option value="Nigeria">Nigeria</option>
																<option value="Nicaragua">Nicaragua</option>
																<option value="Netherlands">Netherlands</option>
																<option value="Norway">Norway</option>
																<option value="Nepal">Nepal</option>
																<option value="Nauru">Nauru</option>
																<option value="NATO">NATO</option>
																<option value="Niue">Niue</option>
																<option value="New Zealand">New Zealand</option>
																<option value="Oman">Oman</option>
																<option value="Orange">Orange</option>
																<option value="Panama">Panama</option>
																<option value="Peru">Peru</option>
																<option value="Frenc.Polynesia">Frenc.Polynesia</option>
																<option value="Pap. New Guinea">Pap. New Guinea</option>
																<option value="Philippines">Philippines</option>
																<option value="Pakistan">Pakistan</option>
																<option value="Poland">Poland</option>
																<option value="St.Pier,Miquel.">St.Pier,Miquel.</option>
																<option value="Pitcairn Islnds">Pitcairn Islnds</option>
																<option value="Puerto Rico">Puerto Rico</option>
																<option value="Palestine">Palestine</option>
																<option value="Portugal">Portugal</option>
																<option value="Palau">Palau</option>
																<option value="Paraguay">Paraguay</option>
																<option value="Qatar">Qatar</option>
																<option value="Reunion">Reunion</option>
																<option value="Romania">Romania</option>
																<option value="Russian Fed.">Russian Fed.</option>
																<option value="Rwanda">Rwanda</option>
																<option value="Saudi Arabia">Saudi Arabia</option>
																<option value="Solomon Islands">Solomon Islands</option>
																<option value="Seychelles">Seychelles</option>
																<option value="Sudan">Sudan</option>
																<option value="Sweden">Sweden</option>
																<option value="Singapore">Singapore</option>
																<option value="Saint Helena">Saint Helena</option>
																<option value="Slovenia">Slovenia</option>
																<option value="Svalbard">Svalbard</option>
																<option value="Slovakia">Slovakia</option>
																<option value="Sierra Leone">Sierra Leone</option>
																<option value="San Marino">San Marino</option>
																<option value="Senegal">Senegal</option>
																<option value="Somalia">Somalia</option>
																<option value="Suriname">Suriname</option>
																<option value="S.Tome,Principe">S.Tome,Principe</option>
																<option value="El Salvador">El Salvador</option>
																<option value="Syria">Syria</option>
																<option value="Swaziland">Swaziland</option>
																<option value="Turksh Caicosin">Turksh Caicosin</option>
																<option value="Chad">Chad</option>
																<option value="French S.Territ">French S.Territ</option>
																<option value="Togo">Togo</option>
																<option value="Thailand">Thailand</option>
																<option value="Tajikistan">Tajikistan</option>
																<option value="Tokelau Islands">Tokelau Islands</option>
																<option value="East Timor">East Timor</option>
																<option value="Turkmenistan">Turkmenistan</option>
																<option value="Tunisia">Tunisia</option>
																<option value="Tonga">Tonga</option>
																<option value="East Timor">East Timor</option>
																<option value="Turkey">Turkey</option>
																<option value="Trinidad,Tobago">Trinidad,Tobago</option>
																<option value="Tuvalu">Tuvalu</option>
																<option value="Taiwan">Taiwan</option>
																<option value="Tanzania">Tanzania</option>
																<option value="Ukraine">Ukraine</option>
																<option value="Uganda">Uganda</option>
																<option value="Minor Outl.Isl.">Minor Outl.Isl.</option>
																<option value="United Nations">United Nations</option>
																<option value="USA">USA</option>
																<option value="Uruguay">Uruguay</option>
																<option value="Uzbekistan">Uzbekistan</option>
																<option value="Vatican City">Vatican City</option>
																<option value="St. Vincent">St. Vincent</option>
																<option value="Venezuela">Venezuela</option>
																<option value="Brit.Virgin Is.">Brit.Virgin Is.</option>
																<option value="Amer.Virgin Is.">Amer.Virgin Is.</option>
																<option value="Vietnam">Vietnam</option>
																<option value="Vanuatu">Vanuatu</option>
																<option value="Wallis,Futuna">Wallis,Futuna</option>
																<option value="Samoa">Samoa</option>
																<option value="Yemen">Yemen</option>
																<option value="Mayotte">Mayotte</option>
																<option value="South Africa">South Africa</option>
																<option value="Zambia">Zambia</option>
																<option value="Zimbabwe">Zimbabwe</option>
															</select>
															{!! $errors->first('employer_country', '<span class="errortext text-red">:message</span>') !!}
														</div>
													</div>
													<div class="form-group">
														<label for="employer_contract" class="col-sm-3">Employement Type</label>
														<div class="col-sm-8">
															<select class="form-control prev_exp userdropdown" name="employer_contract" id="employer_contract">
																<option value="">select</option>
																<option value="Permanent">Permanent</option>
																<option value="Contract">Contract</option>
																<option value="Trainee">Trainee</option>
																<option value="Probation">Probation</option>
															</select>
															{!! $errors->first('employer_contract', '<span class="errortext text-red">:message</span>') !!}
														</div>
													</div>
													
													<div class="form-group">
														<label for="current_designation" class="col-sm-3">Current Designation</label>
														<div class="col-sm-8">
															<input type="text" class="form-control prev_exp" name="current_designation" id="current_designation" placeholder="Current Designation" onkeypress="return checkNum()" value="{{old('current_designation')}}"> 
															{!! $errors->first('current_designation', '<span class="errortext text-red">:message</span>') !!}
														</div>
													</div>
													<div class="form-group">
														<label for="current_ctc" class="col-sm-3">Current CTC(Monthly)</label>
														<div class="col-sm-8">
															<input type="text" class="form-control prev_exp" name="current_ctc" id="current_ctc" placeholder="Current CTC" value="{{old('current_ctc')}}"> 
															{!! $errors->first('current_ctc', '<span class="errortext text-red">:message</span>') !!}
														</div>
													</div>
													<div class="form-group">
														<label for="reason_for_leaving" class="col-sm-3">Reason for Leaving</label>
														<div class="col-sm-8">
															<input type="text" class="form-control prev_exp" name="reason_for_leaving" id="reason" placeholder="Reason for Leaving" onkeypress="return checkNum()" value="{{old('reason_for_leaving')}}"> 
															{!! $errors->first('reason_for_leaving', '<span class="errortext text-red">:message</span>') !!}
														</div>
													</div>
													<div class="form-group">
														<label for="total_experience" class="col-sm-3">Total Years of Experience</label>
														<div class="col-sm-8">
															<input type="text" class="form-control prev_exp" name="total_experience" id="total_exp" placeholder="Total Years of Experience" onkeypress="return isNumberKey()" value="{{old('total_experience')}}">
															{!! $errors->first('total_experience', '<span class="errortext text-red">:message</span>') !!} 
														</div>
													</div>
													<div class="form-group">
														<label for="resume" class="col-sm-3">Upload your Resume* (.doc,.docx,.pdf) (Max File Size - 2 MB)</label>
														<div class="col-sm-8">
															<input type="file" name="resume" id="resume" required>
															{!! $errors->first('resume', '<span class="errortext text-red">:message</span>') !!} 
														</div>
													</div>
											
											
											<br/><br/>
											<div class="form-group">
												<div class="col-sm-7"> 
													<input class="submitbtn btn btn-danger" type="submit" value="Submit" id="submit" />
													<a href="{{ url('/employeezone/empreferfriend') }}" class="btn btn-warning">Cancel</a>
												</div> 
											</div>
                                 
                                     
                                             
                       </div>
                   </div>
                            
                                
                </form>
              
                </div>
                
              @endforeach
            </div>
            <!-- /.box-body -->
          </div>

    </div>


		

		
	</div>
	
	
	
@endforeach
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 2.4.0
    </div>
    <strong>Copyright &copy; 2019 <a href="http://www.vgn.in">VGN Property Developers Pvt. Ltd</a>.</strong> All rights
    reserved.
  </footer>

  
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->



@endsection

@section('script')
@include('newcustomerzone.js.commonjs')
<script src="{{ config('app.AWS_URL')}}/newcustomerzoneassets/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>


<script type="text/javascript">
											
				$(document).ready(function(){
                    
                        $('.sidebar-menu').tree(); 
                    
                    
                    cert = {
					"Non-SSC": {
						"Non-SSC": "Non-SSC"
					},
					"SSC": {
						"SSC": "SSC"
					},
					"ITI": {
						"ITI": "ITI",
						"ITI(Auto Electrician)": "ITI(Auto Electrician)",
						"ITI(Carpentry)": "ITI(Carpentry)",
						"ITI": "ITI(Computer Hardware)",
						"ITI(Computer Hardware)": "ITI(Computer Hardware)",
						"ITI(Darftsman)": "ITI(Darftsman)",
						"ITI(Electrical)": "ITI(Electrical)",
						"ITI(Electronic)": "ITI(Electronic)",
						"ITI(Fitter)": "ITI(Fitter)",
						"ITI(ITI)": "ITI(ITI)",
						"ITI(Machinist)": "ITI(Machinist)",
						"ITI": "ITI(Mechanical)",
						"ITI(Mechanical)": "ITI(Mining)",
						"ITI(Survey)": "ITI(Survey)",
						"ITI(Trainig)": "ITI(Trainig)",
						"ITI(Turner)": "ITI(Turner)",
						"ITI(Welding)": "ITI(Welding)",
						"ITI(Wireman)": "ITI(Wireman)",
						"Automobile": "Automobile"
					},
					"HSC": {
						"HSC": "HSC"
					},
					"Diploma": {
						"AMIE (AUTO)": "AMIE (AUTO)",
						"AMIE(Aeronautical Engineering)": "AMIE(Aeronautical Engineering)",
						"AMIE(Agricultural Engineering)": "AMIE(Agricultural Engineering)",
						"AMIE(Architecture)": "AMIE(Architecture)",
						"AMIE(Automobile)": "AMIE(Automobile)",
						"AMIE(Chemical Engineering)": "AMIE(Chemical Engineering)",
						"AMIE(Civil Engineering)": "AMIE(Civil Engineering)",
						"AMIE(Computer Science)": "AMIE(Computer Science)",
						"AMIE(Construction Engineering)": "AMIE(Construction Engineering)",
						"AMIE(Draftsman)": "AMIE(Draftsman)",
						"AMIE(Electrical Engineering)": "AMIE(Electrical Engineering)",
						"AMIE(Electronics & Telecummunition)": "AMIE(Electronics & Telecummunition)",
						"AMIE(Electronics Engineering)": "AMIE(Electronics Engineering)",
						"AMIE(Environmental Engineering)": "AMIE(Environmental Engineering)",
						"AMIE(Fabrication & Errection Engineering": "AMIE(Fabrication & Errection Engineering",
						"AMIE(Foundation Engineering)": "AMIE(Foundation Engineering)",
						"AMIE(Geological Engineering)": "AMIE(Geological Engineering)",
						"AMIE(Hydrolics Engineering)": "AMIE(Hydrolics Engineering)",
						"AMIE(Industrial Electronis Engineering)": "AMIE(Industrial Electronis Engineering)",
						"AMIE(Industrial Engineering)": "AMIE(Industrial Engineering)",
						"AMIE(Information Technology)": "AMIE(Information Technology)",
						"AMIE(Instrumentation Engineering)": "AMIE(Instrumentation Engineering)",
						"AMIE(Marine Engineering)": "AMIE(Marine Engineering)",
						"AMIE(Mechanical Engineering)": "AMIE(Mechanical Engineering)",
						"AMIE(Metallurgical Engineering)": "AMIE(Metallurgical Engineering)",
						"AMIE(Mining Engineering)": "AMIE(Mining Engineering)",
						"AMIE(Safety Engineering)": "AMIE(Safety Engineering)",
						"AMIE(Structural Engineering)": "AMIE(Structural Engineering)",
						"AMIE(Survey Engineering)": "AMIE(Survey Engineering)",
						"AMIE(Telecommunication Engineering)": "AMIE(Telecommunication Engineering)",
						"D.E(Aeronautical Engineering)": "D.E(Aeronautical Engineering)",
						"D.E(Agricultural Engineering)": "D.E(Agricultural Engineering)",
						"D.E(Architecture)": "D.E(Architecture)",
						"D.E(Automobile Engineering)": "D.E(Automobile Engineering)",
						"D.E(Chemical Engineering)": "D.E(Chemical Engineering)",
						"D.E(Civil Engineering)": "D.E(Civil Engineering)",
						"D.E(Computer Science)": "D.E(Computer Science)",
						"D.E(Construction Engineering)": "D.E(Construction Engineering)",
						"D.E(Draftsman)": "D.E(Draftsman)",
						"D.E(Drilling  Engineering)": "D.E(Drilling  Engineering)",
						"D.E(Electrical Engineering)": "D.E(Electrical Engineering)",
						"D.E(Electronics & Telecummunition)": "D.E(Electronics & Telecummunition)",
						"D.E(Electronics Engineering)": "D.E(Electronics Engineering)",
						"D.E(Environmental Engineering)": "D.E(Environmental Engineering)",
						"D.E(Fabrication & Errection Engineering)": "D.E(Fabrication & Errection Engineering)",
						"D.E(Foundation Engineering)": "D.E(Foundation Engineering)",
						"D.E(Geological Engineering)": "D.E(Geological Engineering)",
						"D.E(Hydrolics Engineering)": "D.E(Hydrolics Engineering)",
						"D.E(Industrial Electronis Engineering)": "D.E(Industrial Electronis Engineering)",
						"Diploma": "D.E(Industrial Engineering)",
						"D.E(Industrial Engineering)": "D.E(Information Technology)",
						"D.E(Instrumentation Engineering)": "D.E(Instrumentation Engineering)",
						"D.E(Marine Engineering)": "D.E(Marine Engineering)",
						"D.E(Mechanical Engineering)": "D.E(Mechanical Engineering)",
						"D.E(Metallurgical Engineering)": "D.E(Metallurgical Engineering)",
						"D.E(Mining Engineering)": "D.E(Mining Engineering)",
						"D.E(Perto Chemical  Engineering)": "D.E(Perto Chemical  Engineering)",
						"D.E(Plant & Maint. Engineering)": "D.E(Plant & Maint. Engineering)",
						"D.E(Polymer  Engineering)": "D.E(Polymer  Engineering)",
						"D.E(Power  Engineering)": "D.E(Power  Engineering)",
						"D.E(Road technology)": "D.E(Road technology)",
						"D.E(Safety Engineering)": "D.E(Safety Engineering)",
						"D.E(Structural Engineering)": "D.E(Structural Engineering)",
						"D.E(Survey Engineering)": "D.E(Survey Engineering)",
						"D.E(Telecommunication Engineering)": "D.E(Telecommunication Engineering)",
						"D.E(Tool  Engineering)": "D.E(Tool  Engineering)",
						"D.E(Transport  Engineering)": "D.E(Transport  Engineering)",
						"DIP IN  MANAGEMENT STUDIES": "DIP IN  MANAGEMENT STUDIES",
						"DIP IN  TAXATION LAW": "DIP IN  TAXATION LAW",
						"DIP(Advertisement & Production)": "DIP(Advertisement & Production)",
						"DIP(Auto CAD)": "DIP(Auto CAD)",
						"DIP(Business Administratiom)": "DIP(Business Administratiom)",
						"DIP(Business Management)": "DIP(Business Management)",
						"DIP(Computer Application)": "DIP(Computer Application)",
						"DIP(Construction Management)": "DIP(Construction Management)",
						"DIP(Contarcts Management)": "DIP(Contarcts Management)",
						"DIP(Environment Management)": "DIP(Environment Management)",
						"DIP(Export & IMPORT)": "DIP(Export & IMPORT)",
						"DIP(Finance Management)": "DIP(Finance Management)",
						"DIP(Hospital Management)": "DIP(Hospital Management)",
						"DIP(Hotel Management)": "DIP(Hotel Management)",
						"DIP(Human Resources Management)": "DIP(Human Resources Management)",
						"DIP(Industrial Management)": "DIP(Industrial Management)",
						"DIP(Industrial Structure)": "DIP(Industrial Structure)",
						"DIP(Journalisam)": "DIP(Journalisam)",
						"DIP(Labour Law & Labour Welfare)": "DIP(Labour Law & Labour Welfare)",
						"DIP(Marketing Management)": "DIP(Marketing Management)",
						"DIP(Mass Comminication)": "DIP(Mass Comminication)",
						"DIP(Mass Comminication)": "DIP(Mass Comminication)",
						"DIP(Material Management)": "DIP(Material Management)",
						"DIP(Operations and Production Management": "DIP(Operations and Production Management",
						"DIP(Personnal Management & Industrial Re": "DIP(Personnal Management & Industrial Re",
						"DIP(Personnal Management)": "DIP(Personnal Management)",
						"DIP(Quality Management)": "DIP(Quality Management)",
						"DIP(Rail Way)": "DIP(Rail Way)",
						"DIP(Safety)": "DIP(Safety)",
						"DIP(Secretary)": "DIP(Secretary)",
						"DIP(Stores)": "DIP(Stores)",
						"DIP(Systems Management)": "DIP(Systems Management)",
						"Material Management": "Material Management",
						"Mechanical": "Mechanical",
						"AutoCAD": "AutoCAD",
						"Draftsman(Civil)": "Draftsman(Civil)",
						"Draftsman(Mechanical)": "Draftsman(Mechanical)",
						"Information Technology": "Information Technology",
						"Cert. Cou.(Computer)": "Cert. Cou.(Computer)",
						"Cert. Cou.(Secretary)": "Cert. Cou.(Secretary)",
						"Cert. Cou.(Typing)": "Cert. Cou.(Typing)",
						"Dip (Marketing Management)": "Dip (Marketing Management)",
						"DIP(Shorthand)": "DIP(Shorthand)"
					},
					"Graduate": {
						"B.A": "B.A",
						"B.A(Catering Technology)": "B.A(Catering Technology)",
						"B.A(Corporate)": "B.A(Corporate)",
						"B.A(Defence)": "B.A(Defence)",
						"B.A(Design Arts)": "B.A(Design Arts)",
						"B.A(Economics)": "B.A(Economics)",
						"B.A(English)": "B.A(English)",
						"B.A(Fisheries)": "B.A(Fisheries)",
						"B.A(Geography)": "B.A(Geography)",
						"B.A(Humanities)": "B.A(Humanities)",
						"B.A(Industrial Relation)": "B.A(Industrial Relation)",
						"B.A(Journalisim)": "B.A(Journalisim)",
						"B.A(Performing Arts)": "B.A(Performing Arts)",
						"B.A(Personnal)": "B.A(Personnal)",
						"B.A(Physical Education)": "B.A(Physical Education)",
						"B.A(Political Science)": "B.A(Political Science)",
						"B.A(Psycology)": "B.A(Psycology)",
						"B.A(Public Relation)": "B.A(Public Relation)",
						"B.A(Social Welfare)": "B.A(Social Welfare)",
						"B.A(Socialogy)": "B.A(Socialogy)",
						"B.A(Travel and Tourism)": "B.A(Travel and Tourism)",
						"B.A(Visual Arts)": "B.A(Visual Arts)",
						"B.Com": "B.Com",
						"B.Com(Costing)": "B.Com(Costing)",
						"B.E(Aeronautical Engineering)": "B.E(Aeronautical Engineering)",
						"B.E(Agricultural Engineering)": "B.E(Agricultural Engineering)",
						"B.E(Architecture)": "B.E(Architecture)",
						"B.E(Automobile)": "B.E(Automobile)",
						"B.E(Chemical Engineering)": "B.E(Chemical Engineering)",
						"B.E(Civil Engineering)": "B.E(Civil Engineering)",
						"B.E(Computer Science)": "B.E(Computer Science)",
						"B.E(Construction Engineering)": "B.E(Construction Engineering)",
						"B.E(Draftsman)": "B.E(Draftsman)",
						"B.E(Electrical Engineering)": "B.E(Electrical Engineering)",
						"B.E(Electronics & Telecummunition)": "B.E(Electronics & Telecummunition)",
						"B.E(Electronics Engineering)": "B.E(Electronics Engineering)",
						"B.E(Environmental Engineering)": "B.E(Environmental Engineering)",
						"B.E(Fabrication & Errection Engineering)": "B.E(Fabrication & Errection Engineering)",
						"B.E(Foundation Engineering)": "B.E(Foundation Engineering)",
						"B.E(Geological Engineering)": "B.E(Geological Engineering)",
						"B.E(Hydrolics Engineering)": "B.E(Hydrolics Engineering)",
						"B.E(Industrial Electronis Engineering)": "B.E(Industrial Electronis Engineering)",
						"B.E(Industrial Engineering)": "B.E(Industrial Engineering)",
						"B.E(Information Technology)": "B.E(Information Technology)",
						"B.E(Instrumentation Engineering)": "B.E(Instrumentation Engineering)",
						"B.E(Marine Engineering)": "B.E(Marine Engineering)",
						"B.E(Material Management)": "B.E(Material Management)",
						"B.E(Mechanical Engineering)": "B.E(Mechanical Engineering)",
						"B.E(Metallurgical Engineering)": "B.E(Metallurgical Engineering)",
						"B.E(Mining Engineering)": "B.E(Mining Engineering)",
						"B.E(Power  Engineering)": "B.E(Power  Engineering)",
						"B.E(Power)": "B.E(Power)",
						"B.E(Production)": "B.E(Production)",
						"B.E(Production)": "B.E(Production)",
						"B.E(Production)": "B.E(Production)",
						"B.E(Road technology)": "B.E(Road technology)",
						"Graduate": "B.E(Safety Engineering)",
						"B.E(Safety Engineering)": "B.E(Structural Engineering)",
						"B.E(Survey Engineering)": "B.E(Survey Engineering)",
						"B.E(Telecommunication Engineering)": "B.E(Telecommunication Engineering)",
						"B.Sc(Aeronautical Engineering)": "B.Sc(Aeronautical Engineering)",
						"B.Sc(Agricultural Engineering)": "B.Sc(Agricultural Engineering)",
						"B.Sc(Agricultural)": "B.Sc(Agricultural)",
						"B.Sc(Architecture)": "B.Sc(Architecture)",
						"B.Sc(Automobile Engineering)": "B.Sc(Automobile Engineering)",
						"B.Sc(Bio Chemistry)": "B.Sc(Bio Chemistry)",
						"B.Sc(Botony)": "B.Sc(Botony)",
						"B.Sc(Chemical Engineering)": "B.Sc(Chemical Engineering)",
						"B.Sc(Chemistry)": "B.Sc(Chemistry)",
						"B.Sc(Civil Engineering)": "B.Sc(Civil Engineering)",
						"B.Sc(Computer Science)": "B.Sc(Computer Science)",
						"B.Sc(Computer)": "B.Sc(Computer)",
						"B.Sc(Construction Engineering)": "B.Sc(Construction Engineering)",
						"B.Sc(Draftsman)": "B.Sc(Draftsman)",
						"B.Sc(Drilling  Engineering)": "B.Sc(Drilling  Engineering)",
						"B.Sc(Economics)": "B.Sc(Economics)",
						"B.Sc(Electrical Engineering)": "B.Sc(Electrical Engineering)",
						"B.Sc(Electronics & Telecummunition)": "B.Sc(Electronics & Telecummunition)",
						"B.Sc(Electronics Engineering)": "B.Sc(Electronics Engineering)",
						"B.Sc(Environmental Engineering)": "B.Sc(Environmental Engineering)",
						"B.Sc(Fabrication & Errection Engineering": "B.Sc(Fabrication & Errection Engineering",
						"B.Sc(Foundation Engineering)": "B.Sc(Foundation Engineering)",
						"B.Sc(Geological Engineering)": "B.Sc(Geological Engineering)",
						"B.Sc(Geology)": "B.Sc(Geology)",
						"B.Sc(Home Science)": "B.Sc(Home Science)",
						"B.Sc(Hydrolics Engineering)": "B.Sc(Hydrolics Engineering)",
						"B.Sc(Industrial Electronis Engineering)": "B.Sc(Industrial Electronis Engineering)",
						"B.Sc(Industrial Engineering)": "B.Sc(Industrial Engineering)",
						"B.Sc(Information Technology)": "B.Sc(Information Technology)",
						"B.Sc(Instrumentation Engineering)": "B.Sc(Instrumentation Engineering)",
						"B.Sc(Marine Engineering)": "B.Sc(Marine Engineering)",
						"B.Sc(Mathematics)": "B.Sc(Mathematics)",
						"B.Sc(Mechanical Engineering)": "B.Sc(Mechanical Engineering)",
						"B.Sc(Metallurgical Engineering)": "B.Sc(Metallurgical Engineering)",
						"B.Sc(Mining Engineering)": "B.Sc(Mining Engineering)",
						"B.Sc(Perto Chemical  Engineering)": "B.Sc(Perto Chemical  Engineering)",
						"B.Sc(Physics)": "B.Sc(Physics)",
						"B.Sc(Plant & Maint. Engineering)": "B.Sc(Plant & Maint. Engineering)",
						"B.Sc(Polymer  Engineering)": "B.Sc(Polymer  Engineering)",
						"B.Sc(Power  Engineering)": "B.Sc(Power  Engineering)",
						"B.Sc(Production Engineering)": "B.Sc(Production Engineering)",
						"B.Sc(Sciences)": "B.Sc(Sciences)",
						"B.Sc(Statistics)": "B.Sc(Statistics)",
						"B.Sc(Structural Engineering)": "B.Sc(Structural Engineering)",
						"B.Sc(Survey Engineering)": "B.Sc(Survey Engineering)",
						"B.Sc(Telecommunication Engineering)": "B.Sc(Telecommunication Engineering)",
						"B.Sc(Tool  Engineering": "B.Sc(Tool  Engineering",
						"B.Sc(Transport  Engineering)": "B.Sc(Transport  Engineering)",
						"B.Sc(Zoology)": "B.Sc(Zoology)",
						"B.Tech(Aeronautical Engineering)": "B.Tech(Aeronautical Engineering)",
						"B.Tech(Agricultural Engineering)": "B.Tech(Agricultural Engineering)",
						"B.Tech(Architecture)": "B.Tech(Architecture)",
						"B.Tech(Automobile Engineering)": "B.Tech(Automobile Engineering)",
						"B.Tech(Chemical Engineering)": "B.Tech(Chemical Engineering)",
						"B.Tech(Civil Engineering)": "B.Tech(Civil Engineering)",
						"B.Tech(Computer Science)": "B.Tech(Computer Science)",
						"B.Tech(Construction Engineering)": "B.Tech(Construction Engineering)",
						"B.Tech(Draftsman)": "B.Tech(Draftsman)",
						"B.Tech(Drilling  Engineering)": "B.Tech(Drilling  Engineering)",
						"B.Tech(Electrical Engineering)": "B.Tech(Electrical Engineering)",
						"B.Tech(Electronics & Telecummunition)": "B.Tech(Electronics & Telecummunition)",
						"B.Tech(Electronics Engineering)": "B.Tech(Electronics Engineering)",
						"B.Tech(Environmental Engineering)": "B.Tech(Environmental Engineering)",
						"B.Tech(Fabrication & Errection Engineering)": "B.Tech(Fabrication & Errection Engineering)",
						"B.Tech(Foundation Engineering)": "B.Tech(Foundation Engineering)",
						"B.Tech(Geological Engineering)": "B.Tech(Geological Engineering)",
						"B.Tech(Hydrolics Engineering)": "B.Tech(Hydrolics Engineering)",
						"B.Tech(Industrial Electronis Engineering": "B.Tech(Industrial Electronis Engineering",
						"B.Tech(Industrial Engineering)": "B.Tech(Industrial Engineering)",
						"B.Tech(Information Technology)": "B.Tech(Information Technology)",
						"B.Tech(Instrumentation Engineering)": "B.Tech(Instrumentation Engineering)",
						"B.Tech(Mechanical Engineering)": "B.Tech(Mechanical Engineering)",
						"B.Tech(Metallurgical Engineering)": "B.Tech(Metallurgical Engineering)",
						"B.Tech(Mining Engineering)": "B.Tech(Mining Engineering)",
						"B.Tech(Perto Chemical  Engineering)": "B.Tech(Perto Chemical  Engineering)",
						"B.Tech(Plant & Maint. Engineering)": "B.Tech(Plant & Maint. Engineering)",
						"B.Tech(Polymer  Engineering)": "B.Tech(Polymer  Engineering)",
						"B.Tech(Power  Engineering)": "B.Tech(Power  Engineering)",
						"B.Tech(Road technology)": "B.Tech(Road technology)",
						"B.Tech(Safety Engineering)": "B.Tech(Safety Engineering)",
						"B.Tech(Structural Engineering)": "B.Tech(Structural Engineering)",
						"B.Tech(Survey Engineering)": "B.Tech(Survey Engineering)",
						"B.Tech(Telecommunication Engineering)": "B.Tech(Telecommunication Engineering)",
						"B.Tech(Tool  Engineering)": "B.Tech(Tool  Engineering)",
						"B.Tech(Transport  Engineering)": "B.Tech(Transport  Engineering)",
						"Bachelor of Business Administraion": "Bachelor of Business Administraion",
						"Bachelor of Business Management": "Bachelor of Business Management",
						"Bachelor of Computer Application": "Bachelor of Computer Application",
						"Bachelor of Computer Science": "Bachelor of Computer Science",
						"Bachelor of Labour Management": "Bachelor of Labour Management",
						"LLB": "LLB",
						"B.Ed.": "B.Ed.",
						"B.Sc. (PCM)": "B.Sc. (PCM)",
						"B.Sc.": "B.Sc.",
						"B.Tech.": "B.Tech.",
						"B.Sc. (Honours)": "B.Sc. (Honours)",
						"B.Com (Honours)": "B.Com (Honours)",
						"B.E. (Production Engg. & Indl. Mgmt.)": "B.E. (Production Engg. & Indl. Mgmt.)",
						"B.E. (Railway Engineering)": "B.E. (Railway Engineering)",
						"LME (Licenciate Mechanical Engineering)": "LME (Licenciate Mechanical Engineering)"
					},
					"Post Graduate": {
						"M.A": "M.A",
						"M.A(Catering Technology)": "M.A(Catering Technology)",
						"M.A(Corporate)": "M.A(Corporate)",
						"M.A(Defence)": "M.A(Defence)",
						"M.A(Design Arts)": "M.A(Design Arts)",
						"M.A(Economics)": "M.A(Economics)",
						"M.A(English)": "M.A(English)",
						"M.A(Fisheries)": "M.A(Fisheries)",
						"M.A(Humanities)": "M.A(Humanities)",
						"M.A(Industrial Relation)": "M.A(Industrial Relation)",
						"M.A(Journalisim)": "M.A(Journalisim)",
						"M.A(Performing Arts)": "M.A(Performing Arts)",
						"M.A(Personnal)": "M.A(Personnal)",
						"M.A(Physical Education)": "M.A(Physical Education)",
						"M.A(Political Science)": "M.A(Political Science)",
						"M.A(Psycology)": "M.A(Psycology)",
						"M.A(Public Relation)": "M.A(Public Relation)",
						"M.A(Social Welfare)": "M.A(Social Welfare)",
						"M.A(Socialogy)": "M.A(Socialogy)",
						"M.A(Travel and Tourism)": "M.A(Travel and Tourism)",
						"M.A(Visual Arts)": "M.A(Visual Arts)",
						"M.Com": "M.Com",
						"M.Com(Costing)": "M.Com(Costing)",
						"M.E(Aeronautical Engineering)": "M.E(Aeronautical Engineering)",
						"M.E(Agricultural Engineering)": "M.E(Agricultural Engineering)",
						"M.E(Architecture)": "M.E(Architecture)",
						"M.E(Automobile Engineering)": "M.E(Automobile Engineering)",
						"M.E(Chemical Engineering)": "M.E(Chemical Engineering)",
						"M.E(Civil Engineering)": "M.E(Civil Engineering)",
						"M.E(Computer Science)": "M.E(Computer Science)",
						"M.E(Construction Engineering)": "M.E(Construction Engineering)",
						"M.E(Draftsman)": "M.E(Draftsman)",
						"M.E(Drilling  Engineering)": "M.E(Drilling  Engineering)",
						"M.E(Electrical Engineering)": "M.E(Electrical Engineering)",
						"M.E(Electronics & Telecummunition)": "M.E(Electronics & Telecummunition)",
						"M.E(Electronics Engineering)": "M.E(Electronics Engineering)",
						"M.E(Environmental Engineering)": "M.E(Environmental Engineering)",
						"M.E(Fabrication & Errection Engineering)": "M.E(Fabrication & Errection Engineering)",
						"M.E(Foundation Engineering)": "M.E(Foundation Engineering)",
						"M.E(Geological Engineering)": "M.E(Geological Engineering)",
						"M.E(Hydrolics Engineering)": "M.E(Hydrolics Engineering)",
						"M.E(Industrial Electronis Engineering)": "M.E(Industrial Electronis Engineering)",
						"M.E(Industrial Engineering)": "M.E(Industrial Engineering)",
						"M.E(Information Technology)": "M.E(Information Technology)",
						"M.E(Instrumentation Engineering)": "M.E(Instrumentation Engineering)",
						"M.E(Marine Engineering)": "M.E(Marine Engineering)",
						"M.E(Mechanical Engineering)": "M.E(Mechanical Engineering)",
						"M.E(Metallurgical Engineering)": "M.E(Metallurgical Engineering)",
						"M.E(Mining Engineering)": "M.E(Mining Engineering)",
						"M.E(Perto Chemical  Engineering)": "M.E(Perto Chemical  Engineering)",
						"M.E(Plant & Maint. Engineering)": "M.E(Plant & Maint. Engineering)",
						"M.E(Polymer  Engineering)": "M.E(Polymer  Engineering)",
						"M.E(Power  Engineering)": "M.E(Power  Engineering)",
						"M.E(Road technology)": "M.E(Road technology)",
						"M.E(Safety Engineering)": "M.E(Safety Engineering)",
						"M.E(Soil Engineering)": "M.E(Soil Engineering)",
						"M.E(Structural Engineering)": "M.E(Structural Engineering)",
						"M.E(Survey Engineering)": "M.E(Survey Engineering)",
						"M.E(Telecommunication Engineering)": "M.E(Telecommunication Engineering)",
						"M.E(Tool  Engineering)": "M.E(Tool  Engineering)",
						"M.E(Transport  Engineering)": "M.E(Transport  Engineering)",
						"M.Philo(Geology)": "M.Philo(Geology)",
						"M.Sc(Aeronautical Engineering)": "M.Sc(Aeronautical Engineering)",
						"M.Sc(Agricultural Engineering)": "M.Sc(Agricultural Engineering)",
						"M.Sc(Agricultural)": "M.Sc(Agricultural)",
						"M.Sc(Architecture)": "M.Sc(Architecture)",
						"M.Sc(Automobile Engineering)": "M.Sc(Automobile Engineering)",
						"M.Sc(Bio Chemistry)": "M.Sc(Bio Chemistry)",
						"M.Sc(Botony)": "M.Sc(Botony)",
						"M.Sc(Chemical Engineering)": "M.Sc(Chemical Engineering)",
						"M.Sc(Chemistry)": "M.Sc(Chemistry)",
						"M.Sc(Civil Engineering)": "M.Sc(Civil Engineering)",
						"M.Sc(Computer Science)": "M.Sc(Computer Science)",
						"M.Sc(Computer)": "M.Sc(Computer)",
						"M.Sc(Construction Engineering)": "M.Sc(Construction Engineering)",
						"M.Sc(Draftsman)": "M.Sc(Draftsman)",
						"M.Sc(Drilling  Engineering)": "M.Sc(Drilling  Engineering)",
						"M.Sc(Economics)": "M.Sc(Economics)",
						"M.Sc(Electrical Engineering)": "M.Sc(Electrical Engineering)",
						"M.Sc(Electronics & Telecummunition)": "M.Sc(Electronics & Telecummunition)",
						"M.Sc(Electronics Engineering)": "M.Sc(Electronics Engineering)",
						"M.Sc(Environmental Engineering)": "M.Sc(Environmental Engineering)",
						"M.Sc(Fabrication & Errection Engineering": "M.Sc(Fabrication & Errection Engineering",
						"M.Sc(Foundation Engineering)": "M.Sc(Foundation Engineering)",
						"M.Sc(Geological Engineering)": "M.Sc(Geological Engineering)",
						"M.Sc(Geology)": "M.Sc(Geology)",
						"M.Sc(Home Science)": "M.Sc(Home Science)",
						"M.Sc(Hydrolics Engineering)": "M.Sc(Hydrolics Engineering)",
						"M.Sc(Industrial Electronis Engineering)": "M.Sc(Industrial Electronis Engineering)",
						"M.Sc(Industrial Engineering)": "M.Sc(Industrial Engineering)",
						"M.Sc(Information Technology)": "M.Sc(Information Technology)",
						"M.Sc(Instrumentation Engineering)": "M.Sc(Instrumentation Engineering)",
						"M.Sc(Marine Engineering)": "M.Sc(Marine Engineering)",
						"M.Sc(Mathematics)": "M.Sc(Mathematics)",
						"M.Sc(Mechanical Engineering)": "M.Sc(Mechanical Engineering)",
						"M.Sc(Metallurgical Engineering)": "M.Sc(Metallurgical Engineering)",
						"M.Sc(Mining Engineering)": "M.Sc(Mining Engineering)",
						"M.Sc(Perto Chemical  Engineering)": "M.Sc(Perto Chemical  Engineering)",
						"M.Sc(Physics)": "M.Sc(Physics)",
						"M.Sc(Plant & Maint. Engineering)": "M.Sc(Plant & Maint. Engineering)",
						"M.Sc(Polymer  Engineering)": "M.Sc(Polymer  Engineering)",
						"M.Sc(Power  Engineering)": "M.Sc(Power  Engineering)",
						"M.Sc(Psychology)": "M.Sc(Psychology)",
						"M.Sc(Safety Engineering)": "M.Sc(Safety Engineering)",
						"M.Sc(Sciences)": "M.Sc(Sciences)",
						"M.Sc(Statistics)": "M.Sc(Statistics)",
						"M.Sc(Structural Engineering)": "M.Sc(Structural Engineering)",
						"M.Sc(Telecommunication Engineering)": "M.Sc(Telecommunication Engineering)",
						"M.Sc(Tool  Engineering)": "M.Sc(Tool  Engineering)",
						"M.Sc(Transport  Engineering)": "M.Sc(Transport  Engineering)",
						"M.Sc(Transport  Engineering)": "M.Sc(Transport  Engineering)",
						"M.Sc(Zoology)": "M.Sc(Zoology)",
						"M.TEC(Water Reso. engg)": "M.TEC(Water Reso. engg)",
						"M.Tech(Aeronautical Engineering)": "M.Tech(Aeronautical Engineering)",
						"M.Tech(Agricultural Engineering)": "M.Tech(Agricultural Engineering)",
						"M.Tech(Architecture)": "M.Tech(Architecture)",
						"M.Tech(Automobile Engineering)": "M.Tech(Automobile Engineering)",
						"M.Tech(Chemical Engineering)": "M.Tech(Chemical Engineering)",
						"M.Tech(Civil Engineering)": "M.Tech(Civil Engineering)",
						"M.Tech(Computer Science)": "M.Tech(Computer Science)",
						"M.Tech(Construction Engineering)": "M.Tech(Construction Engineering)",
						"M.Tech(Draftsman)": "M.Tech(Draftsman)",
						"M.Tech(Drilling Engineering)": "M.Tech(Drilling Engineering)",
						"M.Tech(Electrical Engineering)": "M.Tech(Electrical Engineering)",
						"M.Tech(Electronics & Telecummunition)": "M.Tech(Electronics & Telecummunition)",
						"M.Tech(Electronics Engineering)": "M.Tech(Electronics Engineering)",
						"M.Tech(Environmental Engineering)": "M.Tech(Environmental Engineering)",
						"M.Tech(Fabrication & Errection Engineering)": "M.Tech(Fabrication & Errection Engineering)",
						"M.Tech(Foundation Engineering)": "M.Tech(Foundation Engineering)",
						"M.Tech(Geological Engineering)": "M.Tech(Geological Engineering)",
						"M.Tech(Hydrolics Engineering)": "M.Tech(Hydrolics Engineering)",
						"M.Tech(Industrial Electronis Engineering": "M.Tech(Industrial Electronis Engineering",
						"M.Tech(Industrial Engineering)": "M.Tech(Industrial Engineering)",
						"M.Tech(Information Technology)": "M.Tech(Information Technology)",
						"M.Tech(Instrumentation Engineering)": "M.Tech(Instrumentation Engineering)",
						"M.Tech(Marine Engineering)": "M.Tech(Marine Engineering)",
						"M.Tech(Mechanical Engineering)": "M.Tech(Mechanical Engineering)",
						"M.Tech(Metallurgical Engineering)": "M.Tech(Metallurgical Engineering)",
						"M.Tech(Mining Engineering)": "M.Tech(Mining Engineering)",
						"M.Tech(Perto Chemical Engineering)": "M.Tech(Perto Chemical Engineering)",
						"M.Tech(Plant & Maint. Engineering)": "M.Tech(Plant & Maint. Engineering)",
						"M.Tech(Polymer Engineering)": "M.Tech(Polymer Engineering)",
						"M.Tech(Power Engineering)": "M.Tech(Power Engineering)",
						"M.Tech(Road technology)": "M.Tech(Road technology)",
						"M.Tech(Safety Engineering)": "M.Tech(Safety Engineering)",
						"M.Tech(Structural Engineering)": "M.Tech(Structural Engineering)",
						"M.Tech(Telecommunication Engineering)": "M.Tech(Telecommunication Engineering)",
						"M.Tech(Tool Engineering)": "M.Tech(Tool Engineering)",
						"M.Tech(Transport  Engineering)": "M.Tech(Transport  Engineering)",
						"Master in Computer Application": "Master in Computer Application",
						"Master in Computer Science": "Master in Computer Science",
						"Master in Construction Management": "Master in Construction Management",
						"Master in Finance and Costing": "Master in Finance and Costing",
						"Master in Finance Management": "Master in Finance Management",
						"Master in Human Resouses Development": "Master in Human Resouses Development",
						"Master in Information Technology": "Master in Information Technology",
						"Master in Labour Law & Labour Welfare": "Master in Labour Law & Labour Welfare",
						"Master in Labour Studies": "Master in Labour Studies",
						"Master in Material Management": "Master in Material Management",
						"Master in Personnel Management": "Master in Personnel Management",
						"Master in Social Welfare": "Master in Social Welfare",
						"Master of Labour Management": "Master of Labour Management",
						"Material Management": "Material Management",
						"MBA(Advertisement & Production)": "MBA(Advertisement & Production)",
						"MBA(Business Administratiom)": "MBA(Business Administratiom)",
						"MBA(Business Management)": "MBA(Business Management)",
						"MBA(Computer Application)": "MBA(Computer Application)",
						"MBA(Construction Management)": "MBA(Construction Management)",
						"MBA(Contarcts Management)": "MBA(Contarcts Management)",
						"MBA(Economics)": "MBA(Economics)",
						"MBA(Environment Management)": "MBA(Environment Management)",
						"MBA(Finance Management)": "MBA(Finance Management)",
						"MBA(Hospital Management)": "MBA(Hospital Management)",
						"MBA(Hotel Management)": "MBA(Hotel Management)",
						"MBA(Human Resources Management)": "MBA(Human Resources Management)",
						"MBA(Industrial Management)": "MBA(Industrial Management)",
						"MBA(Industrial Relation)": "MBA(Industrial Relation)",
						"MBA(Industrial Structure)": "MBA(Industrial Structure)",
						"MBA(Journalisam)": "MBA(Journalisam)",
						"MBA(Labour Law & Labour Welfare)": "MBA(Labour Law & Labour Welfare)",
						"MBA(Marketing Management)": "MBA(Marketing Management)",
						"MBA(Material Management)": "MBA(Material Management)",
						"MBA(Operations and Production Management": "MBA(Operations and Production Management",
						"MBA(Personnal Management & Industrial Re": "MBA(Personnal Management & Industrial Re",
						"MBA(Personnal Management)": "MBA(Personnal Management)",
						"MBA(Quality Management)": "MBA(Quality Management)",
						"MBA(Systems Management)": "MBA(Systems Management)",
						"MBA(Tourism)": "MBA(Tourism)",
						"MBBS": "MBBS",
						"MCSC": "MCSC",
						"Mechanical": "Mechanical",
						"Medical": "Medical",
						"Metallurgy": "Metallurgy",
						"Mining": "Mining",
						"MMS(Business Administratiom)": "MMS(Business Administratiom)",
						"MMS(Human Resources Management)": "MMS(Human Resources Management)",
						"MMS(Marketing Management)": "MMS(Marketing Management)",
						"MMS(Material Management)": "MMS(Material Management)",
						"MMS(Operations)": "MMS(Operations)",
						"MS(Civil Engineering)": "MS(Civil Engineering)",
						"MS-BY RESEARCH": "MS-BY RESEARCH",
						"Charterd Accountant": "Charterd Accountant",
						"Charterd Accountant - Inter": "Charterd Accountant - Inter",
						"Charterd Financial Anlyst": "Charterd Financial Anlyst",
						"Labour Law & Labour Welfare": "Labour Law & Labour Welfare",
						"Law": "Law",
						"LLB": "LLB",
						"LLM": "LLM",
						"Accounts": "Accounts",
						"ACWA": "ACWA",
						"Advertisements": "Advertisements",
						"Aeronautical": "Aeronautical",
						"Agricultural": "Agricultural",
						"Architecture": "Architecture",
						"Arts": "Arts",
						"Auto Electrician": "Auto Electrician",
						"AutoCAD": "AutoCAD",
						"Automobile": "Automobile",
						"Company Secretary": "Company Secretary",
						"Computer Hardware": "Computer Hardware",
						"Computer Science": "Computer Science",
						"Construction": "Construction",
						"Contracts Management": "Contracts Management",
						"Corporate Operation": "Corporate Operation",
						"Costing": "Costing",
						"CPA": "CPA",
						"Defence": "Defence",
						"Design Arts": "Design Arts",
						"DNIIT": "DNIIT",
						"Draftsman": "Draftsman",
						"Draftsman(Civil)": "Draftsman(Civil)",
						"Draftsman(Mechanical)": "Draftsman(Mechanical)",
						"Drilling": "Drilling",
						"Economics": "Economics",
						"Electrical": "Electrical",
						"Electronics": "Electronics",
						"Electronics & Telecommunication": "Electronics & Telecommunication",
						"English": "English",
						"Environment": "Environment",
						"Export & IMPORT": "Export & IMPORT",
						"Fabrication & Erection": "Fabrication & Erection",
						"Finance Management": "Finance Management",
						"Fisheries": "Fisheries",
						"Fitter": "Fitter",
						"Foundation": "Foundation",
						"GD(Material Management)": "GD(Material Management)",
						"Geography": "Geography",
						"Geology": "Geology",
						"GNIIT": "GNIIT",
						"Higher Secondary Certificate": "Higher Secondary Certificate",
						"Home Science": "Home Science",
						"Human Resources Management": "Human Resources Management",
						"Humanities": "Humanities",
						"Hydraulics": "Hydraulics",
						"Hydrographic survey": "Hydrographic survey",
						"ICWA": "ICWA",
						"ICWA - Inter": "ICWA - Inter",
						"Import & Export": "Import & Export",
						"Industrial Electronics": "Industrial Electronics",
						"Industrial Engineering": "Industrial Engineering",
						"Industrial Management": "Industrial Management",
						"Industrial Pollution": "Industrial Pollution",
						"Industrial Relation": "Industrial Relation",
						"Industrial Relations": "Industrial Relations",
						"Industrial Structure": "Industrial Structure",
						"Information Technology": "Information Technology",
						"Instrumentation": "Instrumentation",
						"Interior Decoration": "Interior Decoration",
						"Journalism": "Journalism",
						"PGDBA (Finance & Mktg.)": "PGDBA (Finance & Mktg.)",
						"PG (Retail & Marketing)": "PG (Retail & Marketing)",
						"PG (Power Management)": "PG (Power Management)",
						"PG (Energy Management)": "PG (Energy Management)",
						"PG (Plastic Testing & Conversion Techno)": "PG (Plastic Testing & Conversion Techno)",
						"LME (Licenciate Mechanical Engineering)": "LME (Licenciate Mechanical Engineering)",
						"PGPMS (Marketing)": "PGPMS (Marketing)",
						"MMS (Marketing)": "MMS (Marketing)"
					},
					"Certificate Course": {
						"MBA(Finance Management)": "MBA(Finance Management)",
						"Information Technology": "Information Technology",
						"Cert. Cou.(ADVTG&MTG)": "Cert. Cou.(ADVTG&MTG)",
						"Cert. Cou.(Auto Cad)": "Cert. Cou.(Auto Cad)",
						"Cert. Cou.(Auto Electrician)": "Cert. Cou.(Auto Electrician)",
						"Cert. Cou.(Basic Naval Trg)": "Cert. Cou.(Basic Naval Trg)",
						"Cert. Cou.(CCNA)": "Cert. Cou.(CCNA)",
						"Cert. Cou.(Civil)": "Cert. Cou.(Civil)",
						"Cert. Cou.(Computer Hardware)": "Cert. Cou.(Computer Hardware)",
						"Cert. Cou.(Computer)": "Cert. Cou.(Computer)",
						"Cert. Cou.(Darftsman)": "Cert. Cou.(Darftsman)",
						"Cert. Cou.(Electrical)": "Cert. Cou.(Electrical)",
						"Cert. Cou.(Electronic)": "Cert. Cou.(Electronic)",
						"Cert. Cou.(Fitter)": "Cert. Cou.(Fitter)",
						"Cert. Cou.(Hydrografic Survey)": "Cert. Cou.(Hydrografic Survey)",
						"Cert. Cou.(Import & Export)": "Cert. Cou.(Import & Export)",
						"Cert. Cou.(Industrial Relation)": "Cert. Cou.(Industrial Relation)",
						"Cert. Cou.(Intiror Decoration)": "Cert. Cou.(Intiror Decoration)",
						"Cert. Cou.(MCSC)": "Cert. Cou.(MCSC)",
						"Cert. Cou.(MEDIA&ADVTG)": "Cert. Cou.(MEDIA&ADVTG)",
						"Cert. Cou.(Mining)": "Cert. Cou.(Mining)",
						"Cert. Cou.(Pharma)": "Cert. Cou.(Pharma)",
						"Cert. Cou.(Secretary)": "Cert. Cou.(Secretary)",
						"Cert. Cou.(Software Development)": "Cert. Cou.(Software Development)",
						"Cert. Cou.(Survey)": "Cert. Cou.(Survey)",
						"Cert. Cou.(Tour & Travel)": "Cert. Cou.(Tour & Travel)",
						"Cert. Cou.(Trade Union)": "Cert. Cou.(Trade Union)",
						"Cert. Cou.(Turner)": "Cert. Cou.(Turner)",
						"Cert. Cou.(Typing)": "Cert. Cou.(Typing)",
						"Cert. Cou.(Web Designing)": "Cert. Cou.(Web Designing)",
						"Cert. Cou.(Welding)": "Cert. Cou.(Welding)",
						"Cert. Cou.(Wireman)": "Cert. Cou.(Wireman)",
						"Statistics & Computer": "Statistics & Computer",
						"Certificate Course (Nursing)": "Certificate Course (Nursing)"
					},
					"High school": {
						"High school Certificate": "High school Certificate"
					},
					"Professional school": {
						"Professional school Certificate": "Professional school Certificate"
					},
					"Sec.profess.school": {
						"Sec.profess.school Certificate": "Sec.profess.school Certificate"
					},
					"Technical school": {
						"Technical school Certificate": "Technical school Certificate"
					},
					"Trade school": {
						"Trade school Certificate": "Trade school Certificate"
					},
					"Commercial college": {
						"Commercial college Certificate": "Commercial college Certificate"
					},
					"Higher tech. college": {
						"Higher tech. college Certificate": "Higher tech. college Certificate"
					},
					"Higher sec. school": {
						"Higher sec. school Certificate": "Higher sec. school Certificate"
					},
					"University": {
						"University Certificate": "University Certificate"
					},
					"University/college": {
						"University/college Certificate": "University/college Certificate"
					},
					"Technical school": {
						"Technical school Certificate": "Technical school Certificate"
					},
					"Language school": {
						"Language school Certificate": "Language school Certificate"
					},
					"Internal course/sem.": {
						"Internal course/sem. Certificate": "Internal course/sem. Certificate"
					},
					"External course/sem.": {
						"External course/sem. Certificate": "External course/sem. Certificate"
					}
				};
                    
                    var cntry_edu = "{{old('education_country')}}";
                    if(cntry_edu != ''){
                        
                        $("#education_country").find("option[value=" + cntry_edu +"]").attr('selected', 'selected');
                    }
                    var indst = "{{old('industry')}}";
                    if(indst != ''){
                        
                        $("#indst").find("option[value=" + indst +"]").attr('selected', 'selected');
                    }
                    var employer_country = "{{old('employer_country')}}";
                    if(employer_country != ''){
                        
                        $("#employer_country").find("option[value=" + employer_country +"]").attr('selected', 'selected');
                    }
                    var employer_contract = "{{old('employer_contract')}}";
                    if(employer_contract != ''){
                        
                        $("#employer_contract").find("option[value=" + employer_contract +"]").attr('selected', 'selected');
                    }
                    
                    var graduation = $("#graduation").val();
                    if(graduation != ''){
                        var certificateselected = "{{old('certificate')}}";
                       
                         var selectedgrad = $("#graduation").val();
                         //console.log(cert);
                        var opt = "<option value=''>select</option>";
                        $.each(cert, function(i,e){
                            if(i == selectedgrad){
                                $.each(e, function(k,f){
                                    if(f == certificateselected){
                                opt += '<option value="'+f+'" selected="selected">'+f+'</option>';
                                    }else
                                        {
                                            opt += '<option value="'+f+'">'+f+'</option>';
                                        }
                                });
                                    
                            }
                            
                        });
                        $("#certificate").html(opt);
                        
                        
                    }
                    
                    
                    $("#graduation").on('change', function(){
                        var selectedgrad = $("#graduation").val();
                         console.log(cert);
                        var opt = "<option value=''>select</option>";
                        $.each(cert, function(i,e){
                            if(i == selectedgrad){
                                $.each(e, function(k,f){
                                opt += '<option value="'+f+'">'+f+'</option>';
                                });
                                    
                            }
                            
                        });
                        $("#certificate").html(opt);
                    });
                    
                     //Date picker
    $('#datepicker').datepicker({
                   format: 'yyyy-mm-dd'
    }); 
    $('#datepicker_to_from_date').datepicker({
                   format: 'yyyy-mm-dd'
    });
    $('#education_to_date').datepicker({
                   format: 'yyyy-mm-dd'
    });
    $('#expr_from_date').datepicker({
                   format: 'yyyy-mm-dd'
    });
    $('#expr_to_date').datepicker({
                   format: 'yyyy-mm-dd'
    });
                    
                  
                    
				});				
		    </script>
@endsection
