use std::env;
use std::fs;

fn main() {
    let contents = fs::read_to_string("day2input.txt")
        .expect("Something went wrong reading the file");

// let contents = "1-3 a: abcde
// 1-3 b: cdefg
// 2-9 c: ccccccccc";

    let total = contents.lines().fold(0, |count, line| {
        let (policy_str, passwd) = split_once(line);
        let policy = Policy::fromStr(policy_str.to_string());
        if policy.is_ok(passwd.to_string()) {count + 1} else {count}
    });
    println!("total ok : {:?}", total);
}

fn split_once(in_string: &str) -> (&str, &str) {
    let mut splitter = in_string.splitn(2, ':');
    let first = splitter.next().unwrap();
    let second = splitter.next().unwrap();
    (first, second)
}

struct Policy {
    pub min: usize,
    pub max: usize,
    pub letter: char,
}

impl Policy {
    pub fn fromStr(str_pol: String) -> Self {
        let parse1: Vec<&str> = str_pol.split(' ').collect();
        let parse2: Vec<&str> = parse1[0].split('-').collect();
        Policy {
            min: parse2[0].to_string().parse().unwrap(),
            max: parse2[1].to_string().parse().unwrap(),
            letter: parse1[1].chars().next().unwrap(),
        }
    }

    pub fn is_ok(&self, passwd: String) -> bool {
        let v: Vec<char> = passwd.chars().collect();
        (v[self.min] == self.letter && v[self.max] != self.letter) ||
        (v[self.min] != self.letter && v[self.max] == self.letter)
    }
}
