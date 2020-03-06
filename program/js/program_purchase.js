function values(types){
  // 부르는 타입을 마이너스 플러스를 확인후 값에 더하거나 빼는 함수
  let vals=document.getElementById('vals')
  if(types =="plus"){
    document.getElementById('vals').innerHTML=vals.value+1;
  }else{
    if(vals.value>1){
      document.getElementById('vals').value=vals.value-1;
    }else{
      document.getElementById('vals').value=1;
    }
  }
}
