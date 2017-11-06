Proc Load_MultiTHzWavesForPanel(ctrlName) : ButtonControl
 String ctrlName

 //String 	Header, fileName, wavNam
 //Variable	i, startRun, lastRun
 String 	fileName, wavNam
 Variable	i
 silent 1
 pauseupdate

 if(exists("tera0")!=0)
 Abort "You have to kill or rename 'tera0.'"
 endif
 
 if(exists("Optical_Delay_Time0")!=0)
 Abort "You have to kill or rename 'Optical_Delay_Time0.'"
 endif

 NewPath/Q/O THzwave
  i=0
 do
  if(i+startrun<=9)
  wavNam = Header+"0"+num2istr(i+startRun)
  else
  wavNam = Header+num2istr(i+startRun)
  endif
 
  fileName = wavNam+".csv"
   
  LoadWave/J/D/O/K=0/A=Optical_Delay_Time/L={0,34,0,0,1}/P=THzwave fileName
  LoadWave/J/D/O/K=0/A=tera/L={0,34,0,1,1}/P=THzwave fileName
   
  Duplicate/O tera0, $wavNam
  Killwaves tera0 
  Wavestats/Q Optical_Delay_Time0
  Setscale/I x, 0, V_max, $wavNam
  DoWindow/F TDwave
  AppendToGraph/W=TDwave $wavNam
  Killwaves 'Optical_Delay_Time0' 
  i=i+1
  while(i<lastRun-startRun+1)
 
End


Macro Calculation(ctrlName) : ButtonControl
 String CtrlName
  
  String EField
  Variable EF
  Variable V_maxloc_ref
  Variable EFnum=0, gotwave, baseline
  Variable/G startpoint, endpoint
  Variable/G n1,theta1,delta
  
  delta=tmpdelta*2*10^(-14)/2.998

  	n1 = 3.414
  	theta1=2*PI*51.639/360
    //print delta,n1,theta1
  
  silent 1
  PauseUpdate
  
  
  DoWindow/F TDwave

  do
    EField= WaveName("",EFnum,1)
    gotwave=cmpstr(EField, "")
    
   EF = strlen(EField)
//   print EF

//   print EField
   
   if(gotwave!=0)
   wavestats/Q $EField
//   print V_maxloc
   endif
   
  	startpoint=xcsr(A)
    if(EF==5)
  	endpoint=xcsr(B)
 	V_maxloc_ref = V_maxloc
    else
//  	endpoint=xcsr(B)+2.001385
	endpoint=xcsr(B)+V_maxloc-V_maxloc_ref  //それぞれのサンプルのmaxloc（毎回異なる）と、最後に読み込まれたreferenceのmaxloc（固定）との差
    endif
  
//    print "startpoint=",startpoint, "endpoint=",endpoint

    if(gotwave!=0)
    	baseline=$EField[endpoint] //変更点2017.10.25
    	//print EFnum,EField,baseline
    	nFFT(EField,baseline,Autoscale)
    endif
    EFnum+=1
 while(gotwave)
 
 DielectricConst()

 String dispwave=suffix+"_"+ExpDate
 MakeGraph(dispwave)
 
endMacro


Proc DielectricConst()
  Variable c=2.998*10^8, index
  String list, name
  String e1_name, e2_name, n_name, a_name
  
  silent 1
  PauseUpdate

 String/G suffix
 
 if(strlen(wt) == 0)
  suffix = name_sample
  else
  suffix = name_sample + "_" + wt
 endif
 
 index=0
 list=StringList("FN*", ";")

 do
  if (strlen(StringFromList(index,list)) == 0)
   break
  endif
  name = $StringFromList(index,list)
  if (strlen(name) == 0)
  else
   e1_name="e1_" + suffix + "_" + ExpDate + "__" + name
   e2_name="e2_" + suffix + "_" + ExpDate + "__" + name
   //n_name="n_"+name
   //a_name="a_"+name
   
   Duplicate/O ref01_I $e1_name, $e2_name//, $n_name, $a_name
  
   epsilon(e1_name,0)
   epsilon(e2_name,1)
   //$n_name=((($e1_name^2+$e2_name^2)^(1/2)+$e1_name)/2)^(1/2)
   //$a_name=2*2*PI*x*((($e1_name^2+$e2_name^2)^(1/2)-$e1_name)/2)^(1/2)/(c*100)
  endif
  
  index+=1
   
 while(1)

end



Proc epsilon(name,RIflag)
 String name
 variable RIflag
 String FFT_ref,FFT_sig,FFT_wn,I_ref,I_sig,p_ref,p_sig
 String I_trs,p_trs
 Variable num
 
 FFT_ref="ref"+ name[strsearch(name,ExpDate+"__",0)+8,strsearch(name,ExpDate+"__",0)+9] + "_FFT"
 FFT_sig=name_sample + name[strsearch(name,ExpDate+"__",0)+10,strsearch(name,ExpDate+"__",0)+11] + "_FFT"
 num=numpnts($FFT_ref)
 
 I_trs="ref"+ name[strsearch(name,ExpDate+"__",0)+8,strsearch(name,ExpDate+"__",0)+9] + "_wn"
 p_trs=name_sample + name[strsearch(name,ExpDate+"__",0)+10,strsearch(name,ExpDate+"__",0)+11] + "_wn"
 
 I_ref="ref"+ name[strsearch(name,ExpDate+"__",0)+8,strsearch(name,ExpDate+"__",0)+9] + "_I"
 I_sig=name_sample + name[strsearch(name,ExpDate+"__",0)+10,strsearch(name,ExpDate+"__",0)+11] + "_I"
 
 p_ref="ref"+ name[strsearch(name,ExpDate+"__",0)+8,strsearch(name,ExpDate+"__",0)+9] + "_p"
 p_sig=name_sample + name[strsearch(name,ExpDate+"__",0)+10,strsearch(name,ExpDate+"__",0)+11] + "_p"
 
 
   $I_trs=$I_sig/$I_ref
   $p_trs=$p_sig-$p_ref
 
 silent 1
 PauseUpdate
  
  t2index(I_trs,p_trs,"ww4",1000,50,num,1.4,0.01)  //single passから予想した屈折率の初期値を代入
 
 if(RIflag==0)
   iterate(num)
	$name[i]=ww7[i]
   loop
 else
   iterate(num)
	$name[i]=ww8[i]
   loop
 endif
 
  KillWaves ww7,ww8
  SetScale/P x 0,(1/num/delta/2), "Hz", $name
  
end


///////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////


Function mytds_s1(w, x1, x2)	// analysis with assumption of single pass
	Wave w           //w[0]=thickness um  w[1]=freq THz  w[2]=T  w[3]=phase
	Variable x1,x2  // index (real and imaginary)
	Variable/C x    //complex index
	Variable/C n_s=cmplx(1.5,0) //index of the substrate
	Variable AA,BB
	AA=300/(2*Pi*w[0]*w[1])
	x=cmplx(x1,x2)
	BB=w[3]-imag(r2polar(x*(n_s+1)^2/(x+n_s)^2))
	return 1-x1+AA*BB
End

Function mytds_s2(w, x1, x2)	// analysis with assumption of single pass
	Wave w           //w[0]=thickness um  w[1]=freq THz  w[2]=T  w[3]=phase
	Variable x1,x2  // index (real and imaginary)
	Variable/C x    //complex index
	Variable/C n_s=cmplx(1.5,0) //index of the substrate
	Variable AA,BB
	AA=300/(2*Pi*w[0]*w[1])
	x=cmplx(x1,x2)
	BB=cabs(sqrt(w[2])/x/(n_s+1)^2*(x+n_s)^2)
	return x2+AA*ln(BB)
End

Function mytds_m1(w, x1, x2)     // analysis with assumption of multi-reflection
	Wave w  //w[0]=thickness um  w[1]=freq THz  w[2]=T  w[3]=phase
	Variable x1,x2 // index (real and imaginary)
	Variable x=w[1]
	Variable t=w[0]					//thickness
	Variable/C n_f=cmplx(x1,x2)
	Variable/C n_s=cmplx(1.5,0)		// index of the substrate
	Variable/C r21,r23,t12,t23,prop_f,prop_ff, prop_d,t12_a,t23_a
	Variable/C ttt, deno, numer
	r23=(n_f-n_s)/(n_f+n_s)
	r21=(1-n_s)/(1+n_s)
	t12=2*n_s/(n_f+n_s)
	t23=2*n_f/(n_s+n_f)
	t12_a=2*n_s/(n_s+1)
	t23_a=2/(n_s+1)
	prop_ff=2*Pi*t*x/300*cmplx(0,1)
	prop_f=2*Pi*t*x/300*n_f*cmplx(0,1)
	prop_d=2*Pi*t*x/300*(n_f-1)*cmplx(0,1)
	numer=t12*t23/t12_a/t23_a*exp(prop_d)
	deno=(1-r23^2*exp(2*prop_f))/(1-r21^2*exp(2*prop_ff))
	ttt=numer/deno
	return magsqr(ttt)-w[2]
End

Function mytds_m2(w, x1, x2)     // analysis with assumption of multi-reflection
	Wave w  //w[0]=thickness um  w[1]=freq THz  w[2]=T  w[3]=phase
	Variable x1,x2 // index (real and imaginary)
	Variable x=w[1]
	Variable t=w[0]					//thickness
	Variable/C n_f=cmplx(x1,x2)
	Variable/C n_s=cmplx(1.5,0)		// index of the substrate
	Variable/C r23,r21,t12,t23,prop_f,prop_ff, prop_d,t12_a,t23_a
	Variable/C ttt, deno, numer
	r23=(n_f-n_s)/(n_f+n_s)
	r21=(1-n_s)/(1+n_s)
	t12=2*n_s/(n_f+n_s)
	t23=2*n_f/(n_s+n_f)
	t12_a=2*n_s/(n_s+1)
	t23_a=2/(n_s+1)
	prop_ff=2*Pi*t*x/300*cmplx(0,1)
	prop_f=2*Pi*t*x/300*n_f*cmplx(0,1)
	prop_d=2*Pi*t*x/300*(n_f-1)*cmplx(0,1)
	numer=t12*t23/t12_a/t23_a*exp(prop_d)
	deno=(1-r23^2*exp(2*prop_f))/(1-r21^2*exp(2*prop_ff))
	ttt=numer/deno/p2rect(cmplx(1,w[3]))
	return imag(r2polar(ttt))	
End


Macro t2index(ww1,ww2,ww4, thickness,st, fn,in_n,in_k)	
	String ww1,ww2,ww4  //1 trans,  2 phase,  ,  4 output
	Variable st=0,fn=128,  thickness=125
	Variable in_n=1.8, in_k=0.01
	Prompt ww1, "select wave of transmission (power)",popup WaveList("*", ";","")
	Prompt ww2, "select wave of  phase shift",popup WaveList("*", ";","")
	Prompt ww4, "set output wave strings"
	Prompt thickness, "set the thickness of the sample"
	Prompt st, "set the initial pixel"
	Prompt fn, "set the last pixel"
	Prompt in_n, "set initial real index for FindRoot"	
	Prompt in_k, "set initial imaginary index for FindRoot"
	
	
	String ww5=ww4+"_n", ww6=ww4+"_k", ww3="para"
	Silent 1
	PauseUpDate
	Make/N=4/D/O $ww3
	$ww3[0]=thickness

// if  you evaluate index in limited region, set the following 3 lines invalid
	Duplicate/O $ww1 $ww5, $ww6
	 $ww5=NaN
	 $ww6=NaN
	 
	do
	$ww3[1]=pnt2x($ww1, st)
	if(pnt2x($ww1, st)>0)
		$ww3[2]=$ww1[st]
		$ww3[3]=$ww2[st]
		
//  choose the command (single pass or multi pass)
		FindRoots/X={(in_n),(in_k)}/Q  mytds_s1, $ww3, mytds_s2, $ww3   // single-pass
//		FindRoots/X={(in_n),(in_k)}/Q  mytds_m1, $ww3, mytds_m2, $ww3  //multi-pass

		$ww5[st]=W_Root[0]
		$ww6[st]=W_Root[1]

//	If index is strongly dependent of frequency, set the following two lines valid		
		in_n=W_Root[0]
		in_k=W_Root[1]
		
	endif
	st+=1
	while(st-fn-1)
	
//	display $ww5,$ww6 //single-passから初期値を確認するとき
	
	Duplicate/O $ww1 ww7,ww8
		ww7=($ww5)^2-($ww6)^2
		ww8=2*$ww5*$ww6
	
endmacro


///////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////


Proc nFFT(EField,baseline, ac)
  String EField
  Variable baseline, ac
  String outf=EField+"_FFT"
  String outw=EField+"_I"
  String outp=EField+"_p"
  String outc=EField+"_c"
  String outwn=EField+"_wn"
  Variable/C mag
  Variable num,num2

  silent 1
  PauseUpdate

      if (exists(EField)==1)
      		Duplicate/R=(startpoint,endpoint)/O$EField $outf
	  	$outf-=baseline    // set offset value
	  	num=numpnts($outf)
	  	if(ac==0)
	  		if (mod(num,2)==1)
  				InsertPoints num,1,$outf
  			else
  				InsertPoints num,0,$outf
  			endif
  		else
  			InsertPoints num,14976/tmpdelta-num,$outf
  		endif

  		
	
  		FFT $outf 
 	 	num=numpnts($outf)
  		Make/N=(num)/D/O $outw, $outp
  		SetScale/P x 0,(1/num/deltax($EField)/2),"", $outw, $outp
  		//print startpoint, endpoint, deltax($inw)
	
  		iterate(num)   // calculating power spectrum and phase
    			mag=$outf[i]
    			$outw[i]=cabs(mag)^2
    		
    			if (real(mag)<0)
    				$outp[i]=atan(imag(mag)/real(mag))+Pi
    			else
      				$outp[i]=atan(imag(mag)/real(mag))
    			endif
    		
    			if ($outp[i]<0)
      				$outp[i]+=2*Pi
    			endif
  		loop
	
   		// phase control
  		Duplicate/O $outp $outc
  		iterate(num-1)
    			num2=num-1-i
    			$outc[num2]=$outp[num2]-$outp[num2-1]
    		
    			if ($outc[num2]>4)
     				$outc[num2]=0
      				$outc[num2,num-1]-=2*Pi
      			else
      				if ($outc[num2]<-0.8)
        				$outc[num2]= 0
        				$outc[num2,num-1]+= 2*Pi
      				else
        				$outc[num2]=0
      				endif
    			endif
  		loop
  
  		$outp+=$outc
  		//Killwaves $outc
  		

 	else
    		abort "You inputed wrong wavename!"
  	endif
  
       Duplicate/O $outf $outwn
       $outwn=x*10^12
       Redimension/R $outwn
  
end

////////////////////////////////////////////////////////////

Macro MakeGraph(sample)
String sample, FNlist, ff1, wav_e1, wav_e2
Variable fn

FNlist=Stringlist("FN0*", ";")

fn=0
do
 if (strlen(StringFromList(fn, FNlist)) == 0)
  break
 endif
 ff1=$StringFromList(fn, FNlist)
 if (strlen(ff1) == 0)
  FNlist=RemoveListItem(fn, FNlist)
 else
  wav_e1="e1_"+sample+"*"+ff1
  DisplayWaveList3(Wavelist(wav_e1, ";", ""), fn)
  TextBox/C/N=text0/F=0/B=1/A=MC "\\Z24\\F'Symbol'e\\B\\F]0r"
  Legend/C/N=text1/F=0/A=RT
  GraphStyle_e1()
  fn+=1
 endif
while (1)

fn=0
do
 if (strlen(StringFromList(fn, FNlist)) == 0)
  break
 endif
 ff1=$StringFromList(fn, FNlist)
 if (strlen(ff1) == 0)
  FNlist=RemoveListItem(fn, FNlist)
 else
  wav_e2="e2_"+sample+"*"+ff1
  DisplayWaveList3(Wavelist(wav_e2, ";", ""), fn)
  TextBox/C/N=text0/F=0/B=1/A=MC "\\Z24\\F'Symbol'e\\B\\F]0i"
  Legend/C/N=text1/F=0/A=RT
  GraphStyle_e2()
  fn+=1
 endif
while (1)

End


Function DisplayWaveList3(list, fnn)
 String list // A semicolon-separated list.
 Variable fnn
 String eps
 // Get the next wave name

  eps = StringFromList(0, list)

  if (fnn == 0) // Is this the first wave?
    Display $eps
  else
    AppendToGraph $eps
  endif
	
End

////
///平均化及び誤差計算

Macro Cal_av_SD_SDOM_from_TopGraph(ctrlName) : ButtonControl
	String ctrlName
	
  String dammy, EField
  Variable EFnum, gotwave
  
  silent 1
  PauseUpdate
  
  dammy = WaveName("",EFnum,1)
  
  if (stringmatch(dammy, "e1_*") == 1)
  	String av_name = "e1_av__" + suffix
  	String SD_name = "e1_SD_" + suffix
  	String SDOM_name = "e1_SDOM_" + suffix
  else
  	String av_name = "e2_av__" + suffix
  	String SD_name = "e2_SD_" + suffix
  	String SDOM_name = "e2_SDOM_" + suffix
  endif

  Duplicate/O $dammy $av_name, $SD_name, $SDOM_name
  $av_name = 0
  $SD_name= 0
  $SDOM_name = 0
  
  EFnum=0
  
  do
    EField= WaveName("",EFnum,1)
    gotwave=cmpstr(EField, "")
    if(gotwave!=0)
		$av_name += $EField 
    endif
    EFnum+=1
  while(gotwave)
  print (EFnum-1)
  $av_name /= (EFnum-1)
 
 
  EFnum=0
  
  do
    EField= WaveName("",EFnum,1)
    gotwave=cmpstr(EField, "")
    if(gotwave!=0)
		$SD_name += ($EField - $av_name)^2
    endif
    EFnum+=1
  while(gotwave)
  //print (EFnum-1)
  $SD_name /= (EFnum-2)
  $SD_name = sqrt($SD_name)
  
  EFnum=0
 
  do
    EField= WaveName("",EFnum,1)
    gotwave=cmpstr(EField, "")
    if(gotwave!=0)
		$SDOM_name += ($EField - $av_name)^2
    endif
    EFnum+=1
  while(gotwave)
  //print (EFnum-1)
  $SDOM_name /= ((EFnum-2)*(EFnum-1))
  $SDOM_name = sqrt($SDOM_name)
  
  
  AppendToGraph $av_name
  ModifyGraph mode($av_name)=0,rgb($av_name)=(65280,0,0),lsize($av_name)=1.5
  ErrorBars $av_name Y,wave=($SD_name,$SD_name)
  
endMacro




/////////////////////
//      Graph Styles     //
/////////////////////


Proc Electric_Field() : GraphStyle
	PauseUpdate; Silent 1		// modifying window...
	ModifyGraph/Z gFont="Times New Roman",gfSize=10
	ModifyGraph/Z lSize=2
	ModifyGraph/Z tick=2
	ModifyGraph/Z mirror=2
	ModifyGraph/Z minor(bottom)=1
	ModifyGraph/Z standoff=0
	ModifyGraph/Z axOffset(left)=-2.61538,axOffset(bottom)=-0.444444
	Label/Z left "Electric Field / arb.units"
	Label bottom "Delay time / \\U"
	SetAxis/A left
EndMacro


Proc I_and_P() : GraphStyle
	PauseUpdate; Silent 1		// modifying window...
	ModifyGraph/Z gFont="Times New Roman",gfSize=10
	ModifyGraph/Z lSize=2
	ModifyGraph/Z log(left)=1
	ModifyGraph/Z tick=2
	ModifyGraph/Z mirror(bottom)=2
	ModifyGraph/Z minor(bottom)=0
	ModifyGraph/Z standoff=0
	ModifyGraph/Z axOffset(left)=-1.38462,axOffset(right)=-1.61538
	ModifyGraph manTick(bottom)={0,0.5,12,1},manMinor(bottom)={4,50}
	Label/Z left "Intensity / arb.units"
	Label/Z bottom "Frequency / \\U"
	Label/Z right "Phase / rad"
	SetAxis/Z bottom 0,3000000000000
	SetAxis/Z right 0,150
EndMacro


Proc GraphStyle_n() : GraphStyle
	PauseUpdate; Silent 1		// modifying window...
	ModifyGraph/Z gFont="Times New Roman",gfSize=10
	ModifyGraph/Z lSize=2
	ModifyGraph/Z rgb[0]=(65280,65280,0),rgb[1]=(0,0,52224),rgb[2]=(0,0,52224),rgb[3]=(32768,65280,0)
	ModifyGraph/Z rgb[4]=(0,52224,0),rgb[5]=(0,0,52224),rgb[6]=(0,0,52224),rgb[7]=(0,13056,0)
	ModifyGraph/Z tick=2
	ModifyGraph/Z mirror=2
	ModifyGraph/Z minor(bottom)=0
	ModifyGraph/Z standoff=0
	ModifyGraph manTick(bottom)={0,0.5,12,1},manMinor(bottom)={4,50}
	Label/Z left "Refractive index"
	Label/Z bottom "Frequency / \\U"
	SetAxis/Z left 1.8,2.8
	SetAxis/Z bottom 0,1500000000000
EndMacro


Proc GraphStyle_a() : GraphStyle
	PauseUpdate; Silent 1		// modifying window...
	ModifyGraph/Z gFont="Times New Roman",gfSize=10
	ModifyGraph/Z lSize=2
	ModifyGraph/Z rgb[0]=(65280,65280,0),rgb[1]=(0,0,52224),rgb[2]=(0,0,52224),rgb[3]=(32768,65280,0)
	ModifyGraph/Z rgb[4]=(0,52224,0),rgb[5]=(0,0,52224),rgb[6]=(0,0,52224),rgb[7]=(0,13056,0)
	ModifyGraph/Z tick=2
	ModifyGraph/Z mirror=2
	ModifyGraph/Z minor(bottom)=0
	ModifyGraph/Z standoff=0
	ModifyGraph manTick(bottom)={0,0.5,12,1},manMinor(bottom)={4,50}
	Label/Z left "Absorption Coeff. / cm\\S-1\\M"
	Label/Z bottom "Frequency / \\U"
	SetAxis/Z left 0,400
	SetAxis/Z bottom 0,1500000000000
EndMacro


Proc GraphStyle_e1() : GraphStyle
	PauseUpdate; Silent 1		// modifying window...
	ModifyGraph/Z gFont="Times New Roman",gfSize=10
	ModifyGraph/Z mode=3
	ModifyGraph/Z marker=8
	ModifyGraph/Z lSize=2
	ModifyGraph/Z rgb[0]=(0,0,65280),rgb[1]=(65280,0,0),rgb[2]=(0,65280,0)
	ModifyGraph/Z rgb[3]=(65280,43520,0),rgb[4]=(0,0,65280),rgb[5]=(0,0,65280)
	ModifyGraph/Z rgb[6]=(0,0,65280),rgb[7]=(0,0,65280),rgb[8]=(0,0,65280)
	ModifyGraph/Z rgb[9]=(0,0,65280),rgb[10]=(0,0,65280),rgb[11]=(0,0,65280)
	ModifyGraph/Z rgb[12]=(0,0,65280),rgb[13]=(0,0,65280),rgb[14]=(0,0,65280)
	ModifyGraph/Z rgb[15]=(0,0,65280),rgb[16]=(0,0,65280),rgb[17]=(0,0,65280)
	ModifyGraph/Z tick=2
	ModifyGraph/Z mirror=2
	ModifyGraph/Z standoff=0
	ModifyGraph/Z manTick(bottom)={0,0.5,12,1},manMinor(bottom)={4,50}
	Label/Z left "\\Z12\\F'Symbol'\\f02e\\F'Times New Roman''"
	Label/Z bottom "Frequency / \\U"
	SetAxis/Z left 0,8
	SetAxis/Z bottom 0,3000000000000
EndMacro


Proc GraphStyle_e2() : GraphStyle
	PauseUpdate; Silent 1		// modifying window...
	ModifyGraph/Z gFont="Times New Roman",gfSize=10
	ModifyGraph/Z mode=3
	ModifyGraph/Z marker=8
	ModifyGraph/Z lSize=2
	ModifyGraph/Z rgb[0]=(0,0,65280),rgb[1]=(65280,0,0),rgb[2]=(0,65280,0)
	ModifyGraph/Z rgb[3]=(65280,43520,0),rgb[4]=(0,0,65280),rgb[5]=(0,0,65280)
	ModifyGraph/Z rgb[6]=(0,0,65280),rgb[7]=(0,0,65280),rgb[8]=(0,0,65280)
	ModifyGraph/Z rgb[9]=(0,0,65280),rgb[10]=(0,0,65280),rgb[11]=(0,0,65280)
	ModifyGraph/Z rgb[12]=(0,0,65280),rgb[13]=(0,0,65280),rgb[14]=(0,0,65280)
	ModifyGraph/Z rgb[15]=(0,0,65280),rgb[16]=(0,0,65280),rgb[17]=(0,0,65280)
	ModifyGraph/Z tick=2
	ModifyGraph/Z mirror=2
	ModifyGraph/Z standoff=0
	ModifyGraph/Z manTick(bottom)={0,0.5,12,1},manMinor(bottom)={4,50}
	Label/Z left "\\Z12\\F'Symbol'\\f02e\\F'Times New Roman'''"
	Label/Z bottom "Frequency / \\U"
	SetAxis/Z left 0,8
	SetAxis/Z bottom 0,3000000000000
EndMacro



Function CheckProc(ctrlName,checked) : CheckBoxControl
	String ctrlName
	Variable checked
	NVAR Autoscale
	Autoscale=checked

End