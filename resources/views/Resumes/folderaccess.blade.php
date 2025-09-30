                  <ul>
                  @foreach($consplanfiles as $cons)
                                    
                  
                    <?php $name = str_replace(' ','%20',$cons->getRelativePathName()); ?>
                    <li>
  <a href="{{ asset('/portal/employee-zone/resumes/') }}/{{$name}}" >https://vgn.in/portal/employee-zone/resumes/{{$name}} - <?php echo date("Y-M-d H:i:s", substr($cons->getCtime(), 0, 10)); ?> </a></li>
                          @endforeach
                          </ul>

             







