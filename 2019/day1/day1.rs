use std::env;
use std::fs;

fn main() {
    let contents = fs::read_to_string("day1input.txt")
        .expect("Something went wrong reading the file");

    let vols: Vec<i32> = contents.lines().into_iter().map(|line| {
        let mass: i32 = line.parse().unwrap();
        calc_fuel(mass)
    }).collect();
    let vol:i32 = vols.into_iter().sum();
    println!("{}", vol);

}

fn calc_fuel(mass: i32) -> i32 {
    let fmass = (mass / 3) - 2;
    if fmass > 0 {
        fmass + calc_fuel(fmass)
    } else {
        0
    }
}
