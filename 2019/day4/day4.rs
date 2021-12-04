// use std::fs;
use std::iter::FromIterator;

fn checkDouble(n:i32) -> bool {
    let mut hasDouble = false;
    let mut double = '0';
    let stn =  format!("{}", n);
    let mut previous = stn.chars().next().unwrap();
    let stnc: &str = &stn[1..];
    let stnc: Vec<char> = stnc.chars().collect();
    for c in stnc{
        if c == previous {
            if !hasDouble && double < c {
                hasDouble = true;
                double = c.clone();
            } else if double < c {
                return true;
            } else {
                hasDouble = false;
            }
        }
        previous = c;
    }

    // if (double.is_some()){
    //     println!("{:?}", double);
    // }
    return hasDouble;
}

fn checkAsc(n:i32) -> bool {
    let stn =  format!("{}", n);
    // let bvec = stn.as_bytes();
    // let mut sorted = bvec.clone();
    // sorted.sort();


    let s_slice: &str = &stn[..];
    let mut chars: Vec<char> = s_slice.chars().collect();
    chars.sort_by(|a, b| a.cmp(b));

    // println!("test{:?}", chars);
    let sorted = String::from_iter(chars);
    // println!("{}", s);


    stn == sorted
}

fn main() {
    let mut count = 0;
    let min = 382345;
    let max = 843167;
    for n in min..max {
        if checkAsc(n) && checkDouble(n) {
            count = count + 1;
            println!("ok : {}", n);
        }
    }
    println!("{}", count);
}
