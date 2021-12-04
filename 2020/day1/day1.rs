use std::env;
use std::fs;

fn main() {
    let contents = fs::read_to_string("day1input.txt")
        .expect("Something went wrong reading the file");

    let expenses: Vec<i32> = contents.lines().into_iter().map(|l| l.parse().unwrap()).collect();

    for exp in &expenses {
        for exp2 in &expenses {
            for exp3 in &expenses {
                if exp + exp2 + exp3 == 2020 {
                    println!("{}", exp * exp2 * exp3)
                }
            }
        }

    }

}
